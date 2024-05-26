<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Sale;
use App\Traits\Models\WithUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItem extends Model
{
    use HasFactory, WithUuid;

    protected $guarded = [];

    public function sale()
    {
        return $this->hasOne(Sale::class, 'uuid', 'sale_id');
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'uuid', 'item_id');
    }
}
