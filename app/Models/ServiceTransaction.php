<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_transaction_id';

    protected $fillable = [
        'user_id',
        'service_id',
        'employee_id'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id');
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
