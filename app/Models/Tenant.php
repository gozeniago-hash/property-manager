<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tenant extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'name',
        'email',
        'password',
        'phone',
        'move_in_date',
        'move_out_date',
        'status',
        'notes',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'move_out_date' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Tenants without a portal password yet can't log in to the portal.
     */
    public function hasPortalAccess(): bool
    {
        return ! empty($this->password);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function concerns(): HasMany
    {
        return $this->hasMany(Concern::class);
    }
}
