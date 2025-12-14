<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RentalContractStatus: string implements HasLabel, HasColor
{
  case PENDING = 'pending';
  case ACTIVE = 'active';
  case EXPIRED = 'expired';

  public function getLabel(): string
  {
    return match ($this) {
      self::PENDING => 'Pending',
      self::ACTIVE => 'Active',
      self::EXPIRED => 'Expired',
    };
  }

  public function getColor(): string
  {
    return match ($this) {
      self::PENDING => 'warning',
      self::ACTIVE => 'success',
      self::EXPIRED => 'danger',
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
