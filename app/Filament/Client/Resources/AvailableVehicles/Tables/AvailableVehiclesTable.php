<?php

namespace App\Filament\Client\Resources\AvailableVehicles\Tables;

use App\Models\Vehicle;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AvailableVehiclesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->modifyQueryUsing(fn($query) => $query->where('availability_status', 'available'))
      ->columns([
        TextColumn::make('brand.name')
          ->sortable()
          ->searchable(),

        TextColumn::make('model')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('year')
          ->sortable(),

        TextColumn::make('vehicle_type')
          ->label('Type')
          ->badge()
          ->formatStateUsing(fn($state) => match ($state) {
            'car' => 'Car',
            'van' => 'Van',
            'truck' => 'Truck',
            'motorcycle' => 'Motorcycle',
            default => $state,
          })
          ->color(fn($state) => match ($state) {
            'car' => 'success',
            'van' => 'warning',
            'truck' => 'danger',
            'motorcycle' => 'info',
            default => 'gray',
          }),

        TextColumn::make('kilometers')
          ->label('Km')
          ->formatStateUsing(fn($state) => number_format($state, 0, ',', ' ') . ' km')
          ->sortable(),

        TextColumn::make('rental_price_per_day')
          ->label('Price/day')
          ->money('DZD')
          ->sortable()
          ->weight('bold')
          ->color('success'),

        TextColumn::make('availability_status')
          ->label('Status')
          ->formatStateUsing(fn() => 'Disponible')
          ->color('success')
          ->icon('heroicon-o-check-circle')
          ->badge(),
      ])
      ->filters([
        SelectFilter::make('vehicle_type')
          ->label('Type de véhicule')
          ->options([
            'car' => 'Car',
            'van' => 'Van',
            'truck' => 'Truck',
            'motorcycle' => 'Motorcycle',
          ]),

        SelectFilter::make('brand_id')
          ->label('Marque')
          ->relationship('brand', 'name')
          ->searchable()
          ->preload(),

      ])
      ->recordActions([
        Action::make('reserve')
          ->label('Réserver')
          ->icon(Heroicon::OutlinedCalendar)
          ->color('success')
          ->url(
            fn(Vehicle $record): string =>
            route('filament.client.resources.my-reservations.create', [
              'vehicle_id' => $record->id
            ])
          ),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
