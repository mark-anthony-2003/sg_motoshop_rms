<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'item_id',
        'user_id',
        'quantity'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cart(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
