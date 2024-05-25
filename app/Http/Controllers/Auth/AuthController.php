<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function viewLogin()
    {
        if (auth()->check()) return redirect()->route('dashboard.index');
        return view('auth.login');
    }

    public function storeLogin(LoginRequest $request)
    {
        $requestDTO = $request->validated();

        try {
            if (Auth::attempt($requestDTO)) {
                $user = User::where('email', $requestDTO['email'])->isActive()->first();
                if (is_null($user)) return redirect()->route('auth.login')->with('toastError', __('auth.not_active'));

                request()->session()->regenerate();
                return redirect()->route('dashboard.index')->with('toastSuccess', __('auth.success_login'));
            }

            return redirect()->route('auth.login')->with('toastError', __('auth.wrong_password'))->withInput();
        } catch (\Throwable $th) {
            return redirect()->route('auth.login')->with('toastError', __('auth.failed_login'))->withInput();
        }
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route('auth.login')->with('toastSuccess', __('auth.logout'));
    }
}
