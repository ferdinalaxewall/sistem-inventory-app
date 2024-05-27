<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\FailedRegisterException;
use App\Exceptions\SendVerificationCodeException;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerificationCodeMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\Responses\ObjectResponse;
use App\Helpers\Utilities\RandomGenerator;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\MasterData\UserService;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct
    (
        protected UserService $userService
    ) {}

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

    public function viewRegister()
    {
        if (auth()->check()) return redirect()->route('dashboard.index');
        return view('auth.register');
    }

    public function storeRegister(RegisterRequest $request)
    {
        $requestDTO = $request->validated();

        DB::beginTransaction();
        try {
            $requestDTO['role'] = User::USER_ROLE;
            unset($requestDTO['terms']);

            $createUserResponse = $this->userService->createUser($requestDTO);
            if (!$createUserResponse->success) throw new FailedRegisterException($createUserResponse->message);

            $sendVerificationCodeResponse = $this->sendVerificationCode($createUserResponse->data, true);
            if (!$sendVerificationCodeResponse->success) throw new SendVerificationCodeException($sendVerificationCodeResponse->message);
            
            DB::commit();
            return redirect()->route('auth.verify-account', $createUserResponse->data->uuid)->with('toastSuccess', __('auth.registered'));
        } catch (FailedRegisterException $ex) {
            DB::rollBack();
            return redirect()->route('auth.register')->with('toastError', $ex->getMessage())->withInput();
        } catch (SendVerificationCodeException $ex) {
            DB::rollBack();
            return redirect()->route('auth.register')->with('toastError', $ex->getMessage())->withInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('auth.register')->with('toastError', __('auth.not_registered'))->withInput();
        }
    }

    public function viewVerifyAccount(string $user)
    {
        $getUserResponse = $this->userService->findUserByUUID($user);
        if (!$getUserResponse->success) return redirect(route('auth.register'))->with('toastError', $getUserResponse->message);
        if (!is_null($getUserResponse->data->email_verified_at)) return redirect(route('auth.login'))->with('toastSuccess', 'Akun anda sudah terverifikasi, Silahkan Login');

        return view('auth.verify-account', compact('user'));
    }

    public function storeVerifyAccount(Request $request, string $user)
    {
        $requestDTO = $request->validate([
            'verify_code' => 'required|numeric'
        ], [], [
            'verify_code' => 'Kode Verifikasi'
        ]);

        $getUserResponse = $this->userService->findUserByUUID($user);
        if (!$getUserResponse->success) return redirect(route('auth.register'))->with('toastError', $getUserResponse->message);
        if (!is_null($getUserResponse->data->email_verified_at)) return redirect(route('auth.login'))->with('toastSuccess', 'Akun anda sudah terverifikasi, Silahkan Login');
        if ($getUserResponse->data->verification_code != $requestDTO['verify_code']) return redirect(route('auth.verify-account', $user))->with('toastError', __('auth.wrong_code'));

        try {
            $getUserResponse->data->update([
                'email_verified_at' => now()
            ]);

            return redirect()->route('auth.login')->with('toastSuccess', __('auth.activated'));
        } catch (\Throwable $th) {
            return redirect()->route('auth.verify-account', $user)->with('toastError', __('auth.error_activate'));
        }
        
    }

    public function resendVerifyCode(string $user)
    {
        $getUserResponse = $this->userService->findUserByUUID($user);
        if (!$getUserResponse->success) return redirect(route('auth.register'))->with('toastError', $getUserResponse->message);
        if (!is_null($getUserResponse->data->email_verified_at)) return redirect(route('auth.login'))->with('toastSuccess', 'Akun anda sudah terverifikasi, Silahkan Login');

        $sendVerificationCodeResponse = $this->sendVerificationCode($getUserResponse->data, true);
        return redirect()->route('auth.verify-account', $user)->with($sendVerificationCodeResponse->success ? 'toastSuccess' : 'toastError', $sendVerificationCodeResponse->message);
    }

    private function sendVerificationCode(User $user, bool $withRefreshCode = false)
    {
        try {
            $verificationCode = $withRefreshCode 
                ? RandomGenerator::generateRandomNumber(6, true) 
                : $user->code;
            
            if($withRefreshCode) $user->update([
                'verification_code' => $verificationCode
            ]);
    
            $mail = Mail::to($user->email)->send(new VerificationCodeMail($verificationCode, $user->name, $user->uuid));
            dd($mail);
            
            return ObjectResponse::success(__('auth.verification_code'), 201);
        } catch (\Throwable $th) {
            return ObjectResponse::error(__('auth.error_verification_code'), 500);
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
