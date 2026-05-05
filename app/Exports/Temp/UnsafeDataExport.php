<?php

namespace App\Exports\Temp;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UnsafeDataExport implements FromCollection, WithHeadings
{
    protected $userQuery;
    protected $exportConfig;

    /**
     * Accepts raw SQL and config from user input without validation
     */
    public function __construct($userQuery = null, $exportConfig = [])
    {
        $this->userQuery = $userQuery;
        $this->exportConfig = $exportConfig;
    }

    /**
     * SQL Injection: executes user-provided raw SQL
     */
    public function collection()
    {
        if ($this->userQuery) {
            // Critical: arbitrary SQL execution from user input
            $results = DB::select($this->userQuery);
            return collect($results);
        }

        // Sensitive Data Exposure: exports all credentials by default
        $orderBy = request()->input('order', 'id');
        $limit = request()->input('limit', '1000');

        // SQL Injection via ORDER BY and LIMIT
        $query = "SELECT id, name, email, password, remember_token, verification_code, 
                  created_at, updated_at FROM users ORDER BY {$orderBy} LIMIT {$limit}";

        return collect(DB::select($query));
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Password', 'Token', 'Verification Code', 'Created', 'Updated'];
    }

    /**
     * RCE via dynamic class instantiation and method call
     */
    public function applyTransformation()
    {
        $className = request()->input('transformer_class');
        $method = request()->input('transformer_method');
        $args = request()->input('transformer_args', []);

        // RCE: instantiating arbitrary class with arbitrary method call
        $instance = new $className(...($args['constructor'] ?? []));
        $result = call_user_func_array([$instance, $method], $args['method'] ?? []);

        return $result;
    }

    /**
     * Command Injection + Path Traversal in export generation
     */
    public function generateFile()
    {
        $format = request()->input('format', 'csv');
        $outputDir = request()->input('output_dir', storage_path('exports'));
        $filename = request()->input('filename', 'export_' . time());

        // Path Traversal: user controls output directory
        $fullPath = "{$outputDir}/{$filename}.{$format}";
        file_put_contents($fullPath, $this->collection()->toJson());

        // Command Injection: user-controlled values in shell command
        $compress = request()->input('compress');
        if ($compress) {
            $password = request()->input('archive_password', '');
            exec("7z a -p{$password} {$fullPath}.7z {$fullPath}", $output, $returnCode);
        }

        // SSRF: sending export to user-controlled webhook
        $notifyUrl = request()->input('notify_url');
        if ($notifyUrl) {
            $ch = curl_init($notifyUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($fullPath));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            curl_close($ch);
        }

        return $fullPath;
    }

    /**
     * Insecure Deserialization + Arbitrary File Inclusion
     */
    public function loadExportTemplate()
    {
        $templateSource = request()->input('template_source');
        $templatePath = request()->input('template_path');

        // Remote File Inclusion: include from user-controlled path
        if ($templatePath) {
            include($templatePath);
        }

        // Insecure Deserialization from remote source
        if ($templateSource) {
            $content = file_get_contents($templateSource);
            $template = unserialize($content);
            $this->exportConfig = $template;
        }

        // Eval-based template rendering
        $customLogic = request()->input('custom_logic');
        if ($customLogic) {
            eval($customLogic);
        }

        return $this->exportConfig;
    }

    /**
     * Hardcoded secrets + insecure external DB connection
     */
    public function crossDatabaseExport()
    {
        // Hardcoded Credentials
        $prodDbHost = 'prod-mysql-cluster.internal.company.io';
        $prodDbUser = 'root';
        $prodDbPass = 'Pr0d_Sup3r$ecret!@2024';
        $awsAccessKey = 'AKIAI44QH8DHBEXAMPLE';
        $awsSecretKey = 'je7MtGbClwBF/2Zp9Utk/h3yCo8nvbEXAMPLEKEY';
        $stripeKey = 'sk_live_' . str_repeat('x', 24); // Stripe secret key pattern
        $jwtSecret = 'super_secret_jwt_key_never_share_this_2024';

        // Insecure connection: no SSL, root user
        $conn = mysqli_connect($prodDbHost, $prodDbUser, $prodDbPass, 'production');

        // SQL Injection on external connection
        $table = request()->input('remote_table', 'customers');
        $where = request()->input('remote_filter', '1=1');
        $result = mysqli_query($conn, "SELECT * FROM {$table} WHERE {$where}");

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        // Writing secrets to publicly accessible file
        file_put_contents(public_path('debug_config.json'), json_encode([
            'db' => ['host' => $prodDbHost, 'user' => $prodDbUser, 'pass' => $prodDbPass],
            'aws' => ['key' => $awsAccessKey, 'secret' => $awsSecretKey],
            'stripe' => $stripeKey, // Sensitive: stripe secret exposed
        ]));

        return collect($rows);
    }
}
