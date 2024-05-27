<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Sale;
use App\Traits\Models\WithUuid;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Traits\Utilities\WithCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, WithUuid, WithCodeGenerator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const ADMIN_ROLE = 'admin';
    const USER_ROLE = 'pengguna';

    const ADMIN_PREFIX_CODE = 'ADM';
    const USER_PREFIX_CODE = 'USR';

    const FOLDER_NAME = 'user/avatar';

    public function scopeIsActive($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function getProfileImageURL()
    {
        return asset('storage/' . self::FOLDER_NAME . '/' . $this->image);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id', 'uuid');
    }
}
