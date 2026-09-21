<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'type',
        'description',
        'amount',
        'billing_period',
        'due_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'billing_period' => 'date',
        'due_date' => 'date',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function totalPaid(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function balance(): float
    {
        return round((float) $this->amount - $this->totalPaid(), 2);
    }

    public function refreshStatus(): void
    {
        $balance = $this->balance();

        if ($balance <= 0) {
            $status = 'paid';
        } elseif ($this->totalPaid() > 0) {
            $status = 'partial';
        } else {
            $status = 'unpaid';
        }

        if ($status !== $this->status) {
            $this->update(['status' => $status]);
        }
    }
}
