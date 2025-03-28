<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceType extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_type_id';

    protected $fillable = [
        'service_type_name',
        'service_type_price',
        'service_type_image',
        'service_status'
    ];

    public function serviceDetail(): BelongsTo
    {
        return $this->belongsTo(ServiceDetail::class);
    }
}
