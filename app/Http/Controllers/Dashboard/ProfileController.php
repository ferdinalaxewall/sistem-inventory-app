<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Services\MasterData\UserService;

class ProfileController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index()
    {
        return view('dashboard.pages.profile.index');
    }

    public function update(UpdateProfileRequest $request)
    {
        $requestDTO = $request->validated();
        $updateProfileResponse = $this->userService->updateUser($requestDTO, auth()->user()->uuid);

        return $updateProfileResponse->success
            ? redirect()->route('dashboard.profile.index')->with('toastSuccess', 'Profil Berhasil Diubah!')
            : redirect()->route('dashbaord.profile.index')->with('toastError', 'Profil Gagal Diubah');
    }
}
