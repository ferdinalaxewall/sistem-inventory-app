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

    /**
     * Displays the login view if the user is not authenticated, otherwise redirects to the dashboard.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewLogin()
    {
        if (auth()->check()) return redirect()->route('dashboard.index');
        return view('auth.login');
    }

    /**
     * Handles the login process for the application.
     *
     * This method first validates the login request using the `LoginRequest` form request.
     * It then checks if the user with the provided email exists in the database. If the user
     * does not exist or the email is not verified, it redirects the user back to the login
     * page with an error message.
     *
     * If the user exists and the email is verified, it attempts to authenticate the user
     * using the provided credentials. If the authentication is successful, it regenerates
     * the session and redirects the user to the dashboard. If the authentication fails, it
     * redirects the user back to the login page with an error message.
     *
     * If any other exception occurs during the process, it redirects the user back to the
     * login page with a generic error message.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request The login request object.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function storeLogin(LoginRequest $request)
    {
        $requestDTO = $request->validated();

        try {
            $user = User::where('email', $requestDTO['email'])->first();
            if (is_null($user)) return redirect(route('auth.login'))->with('toastError', 'Email tidak terdaftar!');
            if (is_null($user->email_verified_at)) return redirect(route('auth.login'))->with('toastError', __('auth.not_active'));

            if (Auth::attempt($requestDTO)) {
                request()->session()->regenerate();
                return redirect()->route('dashboard.index')->with('toastSuccess', __('auth.success_login'));
            }

            return redirect()->route('auth.login')->with('toastError', __('auth.wrong_password'))->withInput();
        } catch (\Throwable $th) {
            return redirect()->route('auth.login')->with('toastError', __('auth.failed_login'))->withInput();
        }
    }

    /**
     * Displays the registration view if the user is not authenticated, otherwise redirects to the dashboard.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewRegister()
    {
        if (auth()->check()) return redirect()->route('dashboard.index');
        return view('auth.register');
    }

    /**
     * Handles the registration process for the application.
     *
     * This method first validates the registration request using the `RegisterRequest` form request.
     * It then creates a new user with the provided information, sets the user's role to `User::USER_ROLE`,
     * and removes the `terms` field from the request data.
     *
     * The method then calls the `createUser` method of the `userService` to create the new user. If the
     * creation is successful, it sends a verification code to the user's email using the `sendVerificationCode`
     * method of the `userService`.
     *
     * If any exceptions occur during the process, the method rolls back the database transaction and
     * redirects the user back to the registration page with an error message.
     *
     * If the registration and verification code sending are successful, the method redirects the user
     * to the `auth.verify-account` route with the user's UUID, and displays a success message.
     *
     * @param \App\Http\Requests\Auth\RegisterRequest $request The registration request object.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
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

    /**
     * Displays the view for verifying the user's account.
     *
     * This method first checks if the user with the provided UUID exists and if their email has been verified.
     * If the user does not exist or their email has already been verified, it redirects the user to the
     * appropriate route with a success or error message.
     *
     * If the user exists and their email has not been verified, it returns the `auth.verify-account` view
     * with the user's UUID.
     *
     * @param string $user The UUID of the user to be verified.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewVerifyAccount(string $user)
    {
        $getUserResponse = $this->userService->findUserByUUID($user);
        if (!$getUserResponse->success) return redirect(route('auth.register'))->with('toastError', $getUserResponse->message);
        if (!is_null($getUserResponse->data->email_verified_at)) return redirect(route('auth.login'))->with('toastSuccess', 'Akun anda sudah terverifikasi, Silahkan Login');

        return view('auth.verify-account', compact('user'));
    }

    /**
     * Handles the verification of a user's account.
     *
     * This method first validates the request input, ensuring that a valid verification code is provided.
     * It then checks if the user with the given UUID exists and if their email has already been verified.
     * If the user does not exist or their email has already been verified, it redirects the user to the
     * appropriate route with a success or error message.
     *
     * If the user exists and their email has not been verified, it checks if the provided verification
     * code matches the one stored in the user's record. If the codes do not match, it redirects the user
     * back to the verification page with an error message.
     *
     * If the verification code is valid, it updates the user's record to mark their email as verified,
     * and redirects the user to the login page with a success message.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the verification code.
     * @param string $user The UUID of the user to be verified.
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Resends the verification code for the specified user.
     *
     * This method first checks if the user with the given UUID exists and if their email has already been verified.
     * If the user does not exist or their email has already been verified, it redirects the user to the appropriate
     * route with a success or error message.
     *
     * If the user exists and their email has not been verified, it calls the `sendVerificationCode` method to
     * generate a new verification code and send it to the user's email. It then redirects the user to the
     * verification page with a success or error message.
     *
     * @param string $user The UUID of the user to resend the verification code for.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerifyCode(string $user)
    {
        $getUserResponse = $this->userService->findUserByUUID($user);
        if (!$getUserResponse->success) return redirect(route('auth.register'))->with('toastError', $getUserResponse->message);
        if (!is_null($getUserResponse->data->email_verified_at)) return redirect(route('auth.login'))->with('toastSuccess', 'Akun anda sudah terverifikasi, Silahkan Login');

        $sendVerificationCodeResponse = $this->sendVerificationCode($getUserResponse->data, true);
        return redirect()->route('auth.verify-account', $user)->with($sendVerificationCodeResponse->success ? 'toastSuccess' : 'toastError', $sendVerificationCodeResponse->message);
    }

    /**
     * Sends a verification code to the specified user.
     *
     * This method generates a new verification code and updates the user's record with the new code.
     * It then sends an email to the user's email address with the verification code.
     *
     * If the `$withRefreshCode` parameter is true, a new random verification code is generated.
     * Otherwise, the existing verification code for the user is used.
     *
     * @param User $user The user to send the verification code to.
     * @param bool $withRefreshCode Whether to generate a new verification code or use the existing one.
     * @return ObjectResponse The response object containing the success or error message.
     */
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

            return ObjectResponse::success(__('auth.verification_code'), 201);
        } catch (\Throwable $th) {
            return ObjectResponse::error(__('auth.error_verification_code'), 500);
        }
    }

    /**
     * Logs out the current user, invalidates the session, and regenerates the session token.
     * It then redirects the user to the login page with a success message.
     */
    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('auth.login')->with('toastSuccess', __('auth.logout'));
    }
}
