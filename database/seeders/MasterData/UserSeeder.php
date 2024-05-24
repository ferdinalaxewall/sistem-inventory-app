<?php

namespace Database\Seeders\MasterData;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Super Admin',
            'code' => IdGenerator::generate([
                'table' => 'users',
                'field' => 'code',
                'length' => 15,
                'prefix' => User::ADMIN_PREFIX_CODE . '-' . now()->format('dmy') . '-',
                'reset_on_prefix_change' => true
            ]),
            'email' => 'admin@example.com',
            'phone' => '081122334455',
            'address' => 'Bogor, Indonesia',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => User::ADMIN_ROLE,
        ]);
    }
}
