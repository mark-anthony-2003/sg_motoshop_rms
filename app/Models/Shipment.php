<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'shipment_id';

    protected $fillable = [
        'cart_id',
        'total_amount',
        'shipment_status',
        'shipment_method',
        'shipment_date',
        'payment_method',
        'payment_status'
    ];

    public function carts(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'shipment_id');
    }
}
