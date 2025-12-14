<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rentalContracts(): HasMany
    {
        return $this->hasMany(RentalContract::class);
    }

    public function activeContracts(): HasMany
    {
        return $this->rentalContracts()->where('status', 'active');
    }

    public function pendingContracts(): HasMany
    {
        return $this->rentalContracts()->where('status', 'pending');
    }

    public function expiredContracts(): HasMany
    {
        return $this->rentalContracts()->where('status', 'expired');
    }

    public function hasActiveContract(): bool
    {
        return $this->activeContracts()->exists();
    }
}
