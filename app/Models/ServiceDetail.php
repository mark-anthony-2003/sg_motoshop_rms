<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_detail_id';

    protected $fillable = [
        'service_id',
        'service_type_id',
        'part_id'
    ];

    public function serviceTypes(): HasMany
    {
        return $this->hasMany(ServiceType::class);
    }
}
