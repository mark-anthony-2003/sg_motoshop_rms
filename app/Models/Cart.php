<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'item_id'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
    public function cart(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
