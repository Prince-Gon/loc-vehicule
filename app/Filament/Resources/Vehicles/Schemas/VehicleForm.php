<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use App\Enum\VehicleAvailabilityStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VehicleForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('brand_id')
          ->relationship('brand', 'name')
          // ->searchable()
          // ->searchDebounce(500)
          ->preload()
          ->required(),
        TextInput::make('model')
          ->required(),
        TextInput::make('license_plate')
          ->unique()
          ->required(),
        TextInput::make('year')
          ->required(),
        TextInput::make('kilometers')
          ->required()
          ->numeric()
          ->default(0),
        TextInput::make('rental_price_per_day')
          ->required()
          ->numeric(),
        Select::make('availability_status')
          ->options(VehicleAvailabilityStatus::options())
          ->default(VehicleAvailabilityStatus::AVAILABLE->value)
          ->required(),
        Select::make('vehicle_type')
          ->options([
            'sedan' => 'Sedan',
            'suv' => 'Suv',
            'truck' => 'Truck',
            'van' => 'Van',
            'wagon' => 'Wagon',
            'hatchback' => 'Hatchback',
          ])
          ->required(),
        Textarea::make('description')
          ->columnSpanFull(),
      ]);
  }
}
