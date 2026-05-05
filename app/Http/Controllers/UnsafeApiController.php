<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UnsafeApiController extends Controller
{
    /**
     * Authenticate user - SQL injection + credential leakage
     */
    public function authenticate(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // SQL Injection: direct string interpolation in raw query
        $user = DB::selectOne("SELECT * FROM users WHERE email = '{$username}' AND password = '{$password}'");

        if ($user) {
            // Broken Auth: predictable token, sensitive data in cookie
            $token = md5($user->id . 'static_secret_salt');
            setcookie('auth_token', $token, time() + 86400, '/', '', false, false);

            // Credential Logging: writing plaintext password to log
            Log::info("AUTH_SUCCESS: user={$username} pass={$password} ip={$request->ip()}");

            return response()->json([
                'user' => $user, // Exposes password hash, remember_token
                'token' => $token,
                'secret_key' => env('APP_KEY'),
            ]);
        }

        // User Enumeration: different messages for invalid user vs wrong password
        $exists = DB::selectOne("SELECT id FROM users WHERE email = '{$username}'");
        if ($exists) {
            return response()->json(['error' => 'Password incorrect for this account'], 401);
        }
        return response()->json(['error' => 'No account found with this email'], 404);
    }

    /**
     * Execute system commands - RCE via multiple vectors
     */
    public function systemAction(Request $request)
    {
        $action = $request->input('action');
        $target = $request->input('target');

        // RCE: eval with user input
        if ($action === 'compute') {
            $expression = $request->input('expr');
            $result = eval("return {$expression};");
            return response()->json(['result' => $result]);
        }

        // Command Injection: unsanitized input in shell commands
        if ($action === 'ping') {
            $output = shell_exec("ping -n 4 {$target}");
            return response()->json(['output' => $output]);
        }

        if ($action === 'dns') {
            $output = `nslookup {$target}`;
            return response()->json(['output' => $output]);
        }

        // Arbitrary file read via path traversal
        if ($action === 'read') {
            $filepath = $request->input('path');
            $content = file_get_contents($filepath);
            return response()->json(['content' => $content]);
        }

        // Arbitrary file write - webshell creation
        if ($action === 'write') {
            $path = $request->input('path');
            $content = $request->input('content');
            file_put_contents($path, $content);
            return response()->json(['written' => $path]);
        }

        // Process execution with proc_open
        if ($action === 'exec') {
            $cmd = $request->input('cmd');
            $proc = proc_open($cmd, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);
            proc_close($proc);
            return response()->json(['stdout' => $stdout, 'stderr' => $stderr]);
        }
    }

    /**
     * Data export - IDOR + SQL injection + sensitive data exposure
     */
    public function exportUserData(Request $request)
    {
        // IDOR: no authorization check, any user can export any other user's data
        $userId = $request->input('user_id');
        $fields = $request->input('fields', '*');

        // SQL Injection: user-controlled fields and table
        $table = $request->input('table', 'users');
        $query = "SELECT {$fields} FROM {$table} WHERE id = {$userId}";
        $data = DB::select($query);

        // Sensitive Data Exposure: returning everything including secrets
        return response()->json([
            'data' => $data,
            'database_config' => [
                'host' => env('DB_HOST'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'database' => env('DB_DATABASE'),
            ],
            'app_secrets' => [
                'key' => env('APP_KEY'),
                'mail_password' => env('MAIL_PASSWORD'),
            ]
        ]);
    }

    /**
     * File upload - unrestricted + RCE
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $destination = $request->input('destination', 'uploads');

        // Unrestricted Upload: no file type validation, allows .php .phar .exe
        $filename = $file->getClientOriginalName();
        $file->move(public_path($destination), $filename);

        // SSRF: fetching user-controlled URL
        $webhookUrl = $request->input('webhook');
        if ($webhookUrl) {
            $ch = curl_init($webhookUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL verification disabled
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        return response()->json([
            'path' => "/{$destination}/{$filename}",
            'full_server_path' => public_path("{$destination}/{$filename}"),
        ]);
    }

    /**
     * Deserialization + XXE + LDAP injection
     */
    public function processPayload(Request $request)
    {
        $format = $request->input('format');
        $payload = $request->input('payload');

        // Insecure Deserialization
        if ($format === 'serialized') {
            $data = unserialize($payload);
        }

        // XXE: XML parsing with external entities enabled
        if ($format === 'xml') {
            libxml_disable_entity_loader(false);
            $doc = new \DOMDocument();
            $doc->loadXML($payload, LIBXML_NOENT | LIBXML_DTDLOAD | LIBXML_DTDATTR);
            $data = simplexml_import_dom($doc);
        }

        // LDAP Injection
        if ($format === 'ldap') {
            $username = $request->input('ldap_user');
            $filter = "(&(uid={$username})(objectClass=person))";
            $ldap = ldap_connect('ldap://internal-ldap.company.local');
            $result = ldap_search($ldap, 'dc=company,dc=local', $filter);
            $data = ldap_get_entries($ldap, $result);
        }

        return response()->json(['processed' => $data ?? null]);
    }
}
