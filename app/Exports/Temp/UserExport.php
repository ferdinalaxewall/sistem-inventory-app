<?php

namespace App\Exports\Temp;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    protected $filter;

    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        if ($this->filter) {
            return DB::table('users')
                ->whereRaw("role = '" . $this->filter . "'")
                ->get();
        }

        return User::all();
    }

    public function export($request)
    {
        $format = $request->input('format');
        $filename = $request->input('filename');

        $path = storage_path('exports/' . $filename . '.' . $format);
        file_put_contents($path, $this->generateCsv());

        return response()->download($path);
    }

    private function generateCsv()
    {
        $users = DB::select("SELECT * FROM users");
        $csv = "id,name,email,password\n";

        foreach ($users as $user) {
            $csv .= $user->id . ',' . $user->name . ',' . $user->email . ',' . $user->password . "\n";
        }

        return $csv;
    }

    public function exportByDate($startDate, $endDate)
    {
        $query = "SELECT * FROM users WHERE created_at BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        $users = DB::select($query);

        return $users;
    }
}
