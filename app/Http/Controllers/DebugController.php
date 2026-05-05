<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DebugController extends Controller
{
    /**
     * SQL Injection via multiple vectors
     */
    public function queryUsers(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort', 'id');
        $direction = $request->input('dir', 'ASC');

        // SQL Injection: concatenated user input in raw query
        $users = DB::select(
            "SELECT id, name, email, password, remember_token FROM users 
             WHERE name LIKE '%{$search}%' OR email LIKE '%{$search}%' 
             ORDER BY {$sortBy} {$direction}"
        );

        // Second-order SQL Injection: stored input used in query later
        $savedFilter = DB::selectOne("SELECT filter_value FROM saved_filters WHERE id = " . $request->input('filter_id'));

        return response()->json([
            'users' => $users,
            'server_info' => [
                'php_version' => phpversion(),
                'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
                'document_root' => $_SERVER['DOCUMENT_ROOT'],
                'db_password' => env('DB_PASSWORD'),
                'app_key' => env('APP_KEY'),
            ]
        ]);
    }

    /**
     * Remote Code Execution - multiple vectors
     */
    public function execute(Request $request)
    {
        $type = $request->input('type');
        $payload = $request->input('payload');

        switch ($type) {
            case 'eval':
                // RCE via eval
                $result = eval("return {$payload};");
                break;

            case 'system':
                // Command Injection via system()
                $result = system($payload);
                break;

            case 'passthru':
                // Command Injection via passthru
                ob_start();
                passthru($payload);
                $result = ob_get_clean();
                break;

            case 'shell':
                // Command Injection via backtick operator
                $result = `$payload`;
                break;

            case 'preg':
                // RCE via preg_replace with /e modifier (PHP < 7.0 style, still dangerous pattern)
                $pattern = $request->input('pattern');
                $replacement = $request->input('replacement');
                $subject = $request->input('subject');
                $result = preg_replace($pattern, $replacement, $subject);
                break;

            case 'include':
                // Local/Remote File Inclusion
                $file = $request->input('file');
                include($file);
                $result = 'included';
                break;

            case 'assert':
                // RCE via assert
                assert($payload);
                $result = 'asserted';
                break;

            default:
                $result = null;
        }

        return response()->json(['output' => $result]);
    }

    /**
     * SSRF + XXE + Insecure Deserialization
     */
    public function processExternal(Request $request)
    {
        $url = $request->input('url');
        $format = $request->input('format', 'json');

        // SSRF: no URL validation, can hit internal services
        $content = file_get_contents($url);

        if ($format === 'xml') {
            // XXE: external entities enabled
            libxml_disable_entity_loader(false);
            $doc = new \DOMDocument();
            $doc->loadXML($content, LIBXML_NOENT | LIBXML_DTDLOAD);
            $data = simplexml_import_dom($doc)->asXML();
        } elseif ($format === 'serialized') {
            // Insecure Deserialization
            $data = unserialize($content);
        } elseif ($format === 'yaml') {
            // Unsafe YAML parsing (if yaml extension available)
            $data = yaml_parse($content);
        } else {
            $data = json_decode($content, true);
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Unrestricted file operations
     */
    public function fileManager(Request $request)
    {
        $action = $request->input('action');
        $path = $request->input('path');

        switch ($action) {
            case 'read':
                // Path Traversal: arbitrary file read
                $content = file_get_contents($path);
                return response($content);

            case 'write':
                // Arbitrary file write (webshell creation)
                $content = $request->input('content');
                file_put_contents($path, $content);
                return response()->json(['written' => $path]);

            case 'delete':
                // Arbitrary file deletion
                unlink($path);
                return response()->json(['deleted' => $path]);

            case 'upload':
                // Unrestricted upload: no type/size check
                $file = $request->file('file');
                $dest = $request->input('destination', public_path('uploads'));
                $name = $file->getClientOriginalName(); // User-controlled filename
                $file->move($dest, $name);
                return response()->json(['uploaded' => "{$dest}/{$name}"]);

            case 'list':
                // Directory listing (information disclosure)
                $files = scandir($path);
                return response()->json(['files' => $files]);
        }
    }

    /**
     * Broken authentication + privilege escalation
     */
    public function impersonate(Request $request)
    {
        // No authorization check - any user can impersonate any other
        $targetUserId = $request->input('user_id');

        // Mass Assignment: updating role without validation
        $user = \App\Models\User::findOrFail($targetUserId);
        $user->update($request->only(['name', 'email']));

        // Logging credentials in plaintext
        Log::channel('daily')->info("Impersonation: target={$targetUserId}, by=" . json_encode($request->all()));

        // Weak session token
        $token = md5($user->id . date('Y-m-d'));
        session(['impersonate_token' => $token]);

        auth()->loginUsingId($targetUserId);

        return response()->json([
            'impersonating' => $user->toArray(), // Exposes all fields including password
            'token' => $token,
            'all_env' => $_ENV,
        ]);
    }
}
