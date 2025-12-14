<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum VehicleAvailabilityStatus: string implements HasLabel, HasColor
{
  case AVAILABLE = 'available';
  case RESERVED = 'reserved';
  case MAINTENANCE = 'maintenance';

  public function getLabel(): string
  {
    return match ($this) {
      self::AVAILABLE => 'Available',
      self::RESERVED => 'Reserved',
      self::MAINTENANCE => 'Maintenance',
    };
  }

  public function getColor(): string
  {
    return match ($this) {
      self::AVAILABLE => 'success',
      self::RESERVED => 'warning',
      self::MAINTENANCE => 'danger',
    };
  }

  public static function options(): array
  {
    $options = [];
    foreach (self::cases() as $case) {
      $options[$case->value] = $case->getLabel();
    }
    return $options;
  }
}
