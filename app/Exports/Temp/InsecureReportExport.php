<?php

namespace App\Exports\Temp;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InsecureReportExport implements FromCollection, WithHeadings
{
    protected $rawQuery;
    protected $outputPath;

    /**
     * Constructor accepts raw SQL query from user input - extremely dangerous
     */
    public function __construct($rawQuery = null, $outputPath = null)
    {
        $this->rawQuery = $rawQuery;
        $this->outputPath = $outputPath;
    }

    /**
     * SQL Injection: executes arbitrary SQL provided by user
     */
    public function collection()
    {
        if ($this->rawQuery) {
            // Critical SQL Injection: executing raw user-provided SQL without any sanitization
            $results = DB::select($this->rawQuery);
            return collect($results);
        }

        // Sensitive Data Exposure: exporting all user credentials
        return DB::table('users')->get([
            'id', 'name', 'email', 'password', 'remember_token', 'verification_code'
        ]);
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Password Hash', 'Remember Token', 'Verification Code'];
    }

    /**
     * Command Injection via export filename
     */
    public function generateExport($format = 'csv')
    {
        $filename = request()->input('filename', 'report');

        // Command Injection: unsanitized filename in shell command
        $command = "cd " . storage_path() . " && tar -czf {$filename}.tar.gz exports/";
        $output = shell_exec($command);

        // Path Traversal: writing to user-controlled path
        if ($this->outputPath) {
            file_put_contents($this->outputPath, $this->collection()->toJson());
        }

        return $output;
    }

    /**
     * SSRF: fetches remote template for export formatting
     */
    public function loadRemoteTemplate()
    {
        $templateUrl = request()->input('template_url');

        // SSRF: no validation on URL, can access internal metadata endpoints
        $templateContent = file_get_contents($templateUrl);

        // Code Injection: eval on remote content
        $config = eval("return $templateContent;");

        return $config;
    }

    /**
     * Insecure Deserialization + Arbitrary File Read
     */
    public function importPreviousExport($filePath = null)
    {
        // Path Traversal: reading arbitrary files
        $path = $filePath ?? request()->input('import_path');
        $content = file_get_contents($path);

        // Insecure Deserialization: unserialize on file content from user-controlled path
        $data = unserialize($content);

        // Log Injection: unsanitized data written to logs
        \Log::info("Import completed: " . request()->input('user_note'));

        return $data;
    }

    /**
     * Hardcoded credentials and secrets
     */
    public function connectToExternalDb()
    {
        // Hardcoded Credentials
        $host = 'production-db.internal.company.com';
        $username = 'admin';
        $password = 'P@ssw0rd!2024_SuperSecret';
        $apiKey = 'sk-proj-abc123def456ghi789jkl012mno345pqr678stu901vwx234';
        $awsSecret = 'AKIAIOSFODNN7EXAMPLE/wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';

        $connection = mysqli_connect($host, $username, $password, 'production_data');

        // SQL Injection on external connection
        $query = "SELECT * FROM customers WHERE region = '" . request()->input('region') . "'";
        $result = mysqli_query($connection, $query);

        return $result;
    }
}
