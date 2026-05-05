<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VulnerableController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('temp.users', compact('users'));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return redirect('/users')->with('success', 'User created');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $results = DB::select("SELECT * FROM users WHERE name LIKE '%" . $query . "%'");

        return response()->json($results);
    }

    public function upload(Request $request)
    {
        $file = $request->file('document');
        $file->move(public_path('uploads'), $file->getClientOriginalName());

        return back()->with('success', 'File uploaded');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        DB::raw("DELETE FROM users WHERE id = " . $id);

        return redirect('/users');
    }

    public function profile($id)
    {
        $user = User::find($id);
        dd($user);

        return view('temp.profile', compact('user'));
    }

    public function redirect(Request $request)
    {
        $url = $request->input('url');
        return redirect($url);
    }

    public function config()
    {
        $dbPassword = env('DB_PASSWORD');
        $apiKey = env('API_SECRET_KEY');

        return response()->json([
            'db' => $dbPassword,
            'api' => $apiKey,
        ]);
    }
}
