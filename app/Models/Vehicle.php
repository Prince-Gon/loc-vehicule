<?php

namespace App\Models;

use App\Enum\VehicleAvailabilityStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
  /** @use HasFactory<\Database\Factories\VehicleFactory> */
  use HasFactory;
  protected $guarded = [];

  protected $casts = [
    'year' => 'integer',
    'kilometers' => 'integer',
    'rental_price_per_day' => 'decimal:2',
    'availability_status' => VehicleAvailabilityStatus::class,
  ];

  public function brand()
  {
    return $this->belongsTo(Brand::class);
  }

  public function rentalContracts()
  {
    return $this->hasMany(RentalContract::class);
  }

  public function activeContracts()
  {
    return $this->rentalContracts()
      ->where('status', 'active')
      ->orWhere(function ($query) {
        $query->where('status', 'pending')
          ->where('start_date', '<=', now())
          ->where('end_date', '>=', now());
      });
  }

  public function isAvailableForPeriod(Carbon $startDate, Carbon $endDate, ?int $excludeContractId = null): bool
  {
    if ($this->availability_status !== 'available') {
      return false;
    }

    $query = $this->rentalContracts()
      ->whereIn('status', ['pending', 'active'])
      ->where(function ($query) use ($startDate, $endDate) {
        $query->whereBetween('start_date', [$startDate, $endDate])
          ->orWhereBetween('end_date', [$startDate, $endDate])
          ->orWhere(function ($query) use ($startDate, $endDate) {
            $query->where('start_date', '<=', $startDate)
              ->where('end_date', '>=', $endDate);
          });
      });
      
      if($excludeContractId) {
        $query->where('id', '!=', $excludeContractId);
      }

      return $query->count() === 0;
  }
}
