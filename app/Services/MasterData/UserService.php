<?php

namespace App\Services\MasterData;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Responses\ObjectResponse;
use App\Traits\Utilities\HandleUploadedFile;

class UserService
{
    use HandleUploadedFile;

    public function listUsers($filters = [])
    {
        return User::when(!empty($filters['role']), function ($query) use ($filters) {
            $query->where('role', $filters['role']);
        })->when(!empty($filters['is_active']) && $filters['is_active'] == true, function ($query) use ($filters) {
            $query->isActive();
        })->latest()->get();
    }

    public function findUserByUUID(string $user_id)
    {
        $data = User::where('uuid', $user_id)->first();
        return !is_null($data)
            ? ObjectResponse::success(__('crud.fetched', ['name' => 'User']), 200, $data)
            : ObjectResponse::error(__('crud.not_found', ['name' => 'User']), 404);
    }

    public function createUser(array $userDTO)
    {
        try {
            if (!empty($userDTO['image'])) {
                $userDTO['image'] = $this->uploadFile($userDTO['image'], User::FOLDER_NAME);
            }

            $userDTO['password'] = Hash::make($userDTO['password']);
            $userDTO['code'] = (new User)->generateUniqueCode(
                $userDTO['role'] == User::ADMIN_ROLE ? User::ADMIN_PREFIX_CODE : User::USER_PREFIX_CODE
            );
            $createdUser = User::create($userDTO);

            return ObjectResponse::success(
                __('crud.created', ['name' => 'User']), 201, $createdUser
            );
        } catch (\Throwable $th) {
            return ObjectResponse::error(
                __('crud.error_create', ['name' => 'User']), 500, $th->getMessage()
            );
        }
    }

    public function updateUser(array $userDTO, string $user_id)
    {
        $getUserResponse = $this->findUserByUUID($user_id);
        if (!$getUserResponse->success) return $getUserResponse;

        try {
            if (!empty($userDTO['image'])) {
                $userDTO['image'] = $this->uploadFile($userDTO['image'], User::FOLDER_NAME);
            }

            $userDTO['password'] = !empty($userDTO['password']) ? Hash::make($userDTO['password']) : $getUserResponse->data->password;
            $updatedUser = $getUserResponse->data->update($userDTO);

            return ObjectResponse::success(
                __('crud.updated', ['name' => 'User']), 200, $updatedUser
            );
        } catch (\Throwable $th) {
            return ObjectResponse::error(
                __('crud.error_update', ['name' => 'User']), 500, $th->getMessage()
            );
        }
    }

    public function deleteUser(string $user_id)
    {
        $getUserResponse = $this->findUserByUUID($user_id);
        if (!$getUserResponse->success) return $getUserResponse;

        try {
            $getUserResponse->data->delete();

            return ObjectResponse::success(
                __('crud.deleted', ['name' => 'User']), 200
            );
        } catch (\Throwable $th) {
            return ObjectResponse::error(
                __('crud.error_delete', ['name' => 'User']), 500, $th->getMessage()
            );
        }
    }
}