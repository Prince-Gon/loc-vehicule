<?php

namespace App\Filament\Resources\RentalContracts\Schemas;

use App\Enum\RentalContractStatus;
use App\Models\Client;
use App\Models\Vehicle;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class RentalContractForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('vehicle_id')
          ->relationship(
            name: 'vehicle',
            titleAttribute: 'model',
            modifyQueryUsing: fn($query) => $query->where('availability_status', 'available'),
            // ->groupBy('brand.id')
            // ->orderByRelation('brand', 'name')
          )
          ->getOptionLabelFromRecordUsing(fn(Vehicle $record) => "{$record->brand->name} {$record->model} ({$record->license_plate})")
          ->searchable()
          ->preload()
          ->required()
          ->live()
          ->afterStateUpdated(function ($state, Set $set, Get $get) {
            if (!$state || !$get('start_date') || !$get('end_date')) {
              $set('total_price', 0);
              return;
            }

            $vehicle = Vehicle::find($state);
            $days = Carbon::parse($get('start_date'))->diffInDays(Carbon::parse($get('end_date'))) + 1;

            if ($vehicle) {
              $set('total_price', $days * $vehicle->rental_price_per_day);
            }
          }),
        Select::make('client_id')
          ->relationship(name: 'client', titleAttribute: 'first_name')
          ->getOptionLabelFromRecordUsing(fn(Client $record) => "{$record->first_name}  {$record->last_name}")
          ->required(),
        DatePicker::make('start_date')
          ->required()
          ->live()
          ->afterStateUpdated(function ($state, Set $set, Get $get) {
            if ($state && $get('vehicle_id') && $get('end_date')) {
              $vehicle = Vehicle::find($get('vehicle_id'));
              $days = Carbon::parse($state)->diffInDays(Carbon::parse($get('end_date'))) + 1;
              $set('total_price', $days * $vehicle->rental_price_per_day);
            }
          }),
        DatePicker::make('end_date')
          ->required()
          ->live()
          ->afterStateUpdated(function ($state, Set $set, Get $get) {
            if ($state && $get('vehicle_id') && $get('start_date')) {
              $vehicle = Vehicle::find($get('vehicle_id'));
              $days = Carbon::parse($get('start_date'))->diffInDays(Carbon::parse($state)) + 1;
              $set('total_price', $days * $vehicle->rental_price_per_day);
            }
          })
          ->after('start_date'),
        TextInput::make('total_price')
          ->required()
          ->numeric()
          ->prefix('DZD')
          ->readOnly(),
        // Select::make('status')
        //   ->options(RentalContractStatus::options())
        //   ->default('pending')
        //   ->required(),
        // TextInput::make('pdf_path'),
      ]);
  }
}
