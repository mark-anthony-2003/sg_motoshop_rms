<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Finance extends Model
{
    use HasFactory;

    protected $primaryKey = 'finance_id';

    protected $fillable = [
        'accounts',
        'date_recorded'
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }
    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }
    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }
}
