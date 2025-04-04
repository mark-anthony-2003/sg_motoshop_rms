<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->hasMany(User::class);
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function employee(): HasOne
    {
        return $this->HasOne(Employee::class);
    }
}
