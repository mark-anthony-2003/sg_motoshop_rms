<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'user_id',
        'service_transaction_id',
        'salary_type_id',
        'position_type_id',
        'date_hired'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function serviceTransaction(): BelongsTo
    {
        return $this->belongsTo(ServiceTransaction::class, 'employee_id');
    }
    public function positionTypes(): HasMany
    {
        return $this->hasMany(PositionType::class);
    }
    public function salaryTypes(): HasMany
    {
        return $this->hasMany(SalaryType::class);
    }
}
