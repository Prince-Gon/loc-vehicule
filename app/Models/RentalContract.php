<?php

namespace App\Models;

use App\Enum\RentalContractStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalContract extends Model
{
  /** @use HasFactory<\Database\Factories\RentalContractFactory> */
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'total_price' => 'decimal:2',
    'status' => RentalContractStatus::class,
  ];

  public function vehicle(): BelongsTo
  {
    return $this->belongsTo(Vehicle::class);
  }
  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }

  public function getDurationInDaysAttribute(): int
  {
    return $this->start_date->diffInDays($this->end_date) + 1;
  }

  public function isActive(): bool
  {
    return $this->status === 'active' && Carbon::now()->between($this->start_date, $this->end_date);
  }

  public function isExpired(): bool
  {
    return Carbon::now()->greaterThan($this->end_date) && $this->status === 'expired';
  }
}
