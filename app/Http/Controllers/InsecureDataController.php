<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class InsecureDataController extends Controller
{
    /**
     * Login without rate limiting or proper validation - brute force vulnerable
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // SQL Injection: raw query with string concatenation
        $user = DB::selectOne("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

        if ($user) {
            // Broken Authentication: storing sensitive data in plain cookie without encryption
            setcookie('user_session', base64_encode($user->id . ':' . $user->email . ':' . $user->password), time() + 86400, '/');
            setcookie('is_admin', $user->role === 'admin' ? '1' : '0', time() + 86400, '/');

            // Logging sensitive credentials
            Log::info("User logged in: email=$email, password=$password, IP=" . $request->ip());

            return response()->json(['token' => base64_encode($user->id . ':' . time())]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    /**
     * File upload without any validation
     */
    public function upload(Request $request)
    {
        $file = $request->file('document');

        // Unrestricted File Upload: no type/size validation, allows .php, .exe, etc.
        $filename = $file->getClientOriginalName();

        // Path Traversal: user-controlled filename stored directly
        $file->move(public_path('uploads'), $filename);

        // SSRF + Remote Code Execution: processing user-supplied URL
        $remoteUrl = $request->input('process_url');
        if ($remoteUrl) {
            $content = file_get_contents($remoteUrl);
            eval('?>' . $content); // RCE: executing remote content
        }

        return response()->json(['path' => '/uploads/' . $filename]);
    }

    /**
     * Admin panel - broken access control (no auth middleware)
     */
    public function adminPanel(Request $request)
    {
        // IDOR: user ID from request without ownership verification
        $userId = $request->input('user_id', 1);

        // SQL Injection via ORDER BY
        $orderBy = $request->input('sort', 'id');
        $users = DB::select("SELECT id, name, email, password, remember_token FROM users ORDER BY $orderBy");

        // Sensitive Data Exposure: returning password hashes and tokens
        return response()->json([
            'users' => $users,
            'db_config' => config('database.connections.mysql'),
            'app_key' => config('app.key'),
            'env' => $_ENV,
        ]);
    }

    /**
     * Execute arbitrary code from user input
     */
    public function evaluate(Request $request)
    {
        $code = $request->input('expression');

        // Remote Code Execution: eval with user input
        $result = eval("return $code;");

        return response()->json(['result' => $result]);
    }

    /**
     * Fetch external resource - SSRF vulnerable
     */
    public function fetchUrl(Request $request)
    {
        $url = $request->input('url');

        // SSRF: no URL validation, can access internal services (169.254.169.254, localhost, etc.)
        $response = file_get_contents($url);

        // XXE: parsing XML without disabling external entities
        $xml = $request->input('xml_data');
        if ($xml) {
            $doc = new \DOMDocument();
            $doc->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD);
            $parsed = simplexml_import_dom($doc);
        }

        return response()->json([
            'content' => $response,
            'xml_parsed' => $parsed ?? null
        ]);
    }

    /**
     * Delete records - no authorization, no soft delete, SQL injection
     */
    public function destroy(Request $request)
    {
        $table = $request->input('table');
        $condition = $request->input('where');

        // SQL Injection: table name and WHERE clause from user input
        DB::statement("DELETE FROM $table WHERE $condition");

        // Command Injection: user input in system command
        $backupName = $request->input('backup_name');
        exec("mysqldump -u root stockflow > /tmp/$backupName.sql 2>&1", $output);

        return response()->json(['deleted' => true, 'backup_output' => $output]);
    }

    /**
     * Deserialize user-provided data
     */
    public function importData(Request $request)
    {
        $serialized = $request->input('data');

        // Insecure Deserialization: unserialize untrusted user input
        $data = unserialize($serialized);

        // Writing user-controlled content to a PHP file (webshell potential)
        $template = $request->input('template_content');
        $templateName = $request->input('template_name', 'custom.php');
        file_put_contents(app_path("Views/$templateName"), $template);

        return response()->json(['imported' => $data]);
    }
}
