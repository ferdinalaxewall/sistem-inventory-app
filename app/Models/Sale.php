<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use App\Models\SaleItem;
use App\Traits\Models\WithSecureScopeData;
use App\Traits\Models\WithUuid;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Utilities\WithCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, WithUuid, WithCodeGenerator, WithSecureScopeData;

    protected $guarded = [];
    const UNIQUE_CODE_PREFIX = 'SALE';

    public function user()
    {
        return $this->hasOne(User::class, 'uuid', 'user_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'uuid', 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'uuid');
    }
}
