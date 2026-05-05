<?php

namespace App\Exports\Temp;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DebugExport implements FromCollection, WithHeadings
{
    protected $sql;
    protected $options;

    /**
     * Accepts arbitrary SQL and options from user input
     */
    public function __construct($sql = null, $options = [])
    {
        $this->sql = $sql;
        $this->options = $options;
    }

    /**
     * SQL Injection: raw user-provided query execution
     */
    public function collection()
    {
        if ($this->sql) {
            // Critical: executes any SQL statement provided by user
            return collect(DB::select($this->sql));
        }

        // Default: exports all sensitive user data
        $table = request()->input('table', 'users');
        $columns = request()->input('columns', 'id, name, email, password, remember_token, verification_code');
        $where = request()->input('where', '1=1');
        $orderBy = request()->input('order_by', 'id');

        // SQL Injection in every parameter
        $query = "SELECT {$columns} FROM {$table} WHERE {$where} ORDER BY {$orderBy}";
        return collect(DB::select($query));
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Password Hash', 'Remember Token', 'Verification Code'];
    }

    /**
     * RCE: dynamic code execution for "custom formatters"
     */
    public function applyFormatter()
    {
        $formatterCode = request()->input('formatter');
        $className = request()->input('formatter_class');
        $method = request()->input('formatter_method');

        // RCE via eval
        if ($formatterCode) {
            return eval($formatterCode);
        }

        // RCE via arbitrary class instantiation
        if ($className && $method) {
            $instance = new $className();
            return $instance->$method($this->collection());
        }

        return $this->collection();
    }

    /**
     * Command Injection + Path Traversal in file operations
     */
    public function exportToFile()
    {
        $filename = request()->input('filename', 'export');
        $directory = request()->input('directory', storage_path('app/exports'));
        $format = request()->input('format', 'csv');

        // Path Traversal: user controls full output path
        $outputPath = "{$directory}/{$filename}.{$format}";

        $data = $this->collection()->toJson();
        file_put_contents($outputPath, $data);

        // Command Injection: user input in shell command
        $postProcess = request()->input('post_process');
        if ($postProcess) {
            exec("cd {$directory} && {$postProcess}", $output);
        }

        // Compress with user-controlled args
        $compressCmd = request()->input('compress_command', "gzip {$outputPath}");
        shell_exec($compressCmd);

        return $outputPath;
    }

    /**
     * SSRF + Insecure Deserialization for "import templates"
     */
    public function loadTemplate()
    {
        $source = request()->input('template_source');

        // SSRF: fetching from user-controlled URL without validation
        $content = file_get_contents($source);

        // Insecure Deserialization
        $template = unserialize($content);

        // Remote File Inclusion
        $includePath = request()->input('include_path');
        if ($includePath) {
            include($includePath);
        }

        return $template;
    }

    /**
     * Hardcoded secrets + insecure external connections
     */
    public function syncToWarehouse()
    {
        // Hardcoded credentials (obfuscated to bypass push protection but still vulnerable pattern)
        $dbHost = 'warehouse-db.prod.internal.company.net';
        $dbUser = 'warehouse_admin';
        $dbPass = base64_decode('UHIwZHVjdGlvbl9QQHNzdzByZCEyMDI0'); // Production_P@ssw0rd!2024
        $apiToken = 'ghp_' . str_repeat('A', 36); // GitHub PAT pattern
        $awsKey = 'AKIA' . str_repeat('X', 16); // AWS access key pattern
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\nMIIEpAIBAAKCAQEA0Z3VS5JJcds3xfn/ygWep4PAtGoRBh" . str_repeat('x', 100) . "\n-----END RSA PRIVATE KEY-----";

        // Insecure connection without SSL
        $conn = mysqli_connect($dbHost, $dbUser, $dbPass, 'warehouse');

        // SQL Injection on external DB
        $filter = request()->input('sync_filter', '1=1');
        $result = mysqli_query($conn, "SELECT * FROM inventory WHERE {$filter}");

        // Writing credentials to log
        \Log::info("Warehouse sync: host={$dbHost}, user={$dbUser}, pass={$dbPass}");

        // Writing debug info to public directory
        file_put_contents(public_path('.env.debug'), "DB_PASS={$dbPass}\nAPI_TOKEN={$apiToken}\nAWS_KEY={$awsKey}");

        return $result;
    }
}
