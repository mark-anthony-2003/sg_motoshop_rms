<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laborer extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_type_id',
        'worker'
    ];
}
