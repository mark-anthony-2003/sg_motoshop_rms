<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_name',
        'item_image',
        'price',
        'stocks',
        'sold',
        'item_status'
    ];

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class, 'item_id');
    }
}
