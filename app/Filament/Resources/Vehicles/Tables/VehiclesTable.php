<?php

namespace App\Filament\Resources\Vehicles\Tables;

use App\Enum\VehicleAvailabilityStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VehiclesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('brand.name')
          ->numeric()
          ->sortable(),
        TextColumn::make('model')
          ->searchable(),
        TextColumn::make('license_plate')
          ->searchable(),
        TextColumn::make('year'),
        TextColumn::make('kilometers')
          ->numeric()
          ->sortable(),
        TextColumn::make('rental_price_per_day')
          ->numeric()
          ->money('dzd')
          ->sortable(),
        TextColumn::make('vehicle_type')
          ->badge(),
        TextColumn::make('availability_status')
          ->formatStateUsing(fn($state) => $state->getLabel())
          ->color(fn($state) => $state->getColor())
          ->badge(),
        // ->action(
        //   Action::make('change_status')
        //     ->label('Change Status')
        //     ->icon(Heroicon::ArrowDownLeft)
        //     ->schema([
        //       Select::make('availability_status')
        //         ->options(VehicleAvailabilityStatus::options())
        //     ])
        //     ->action(function ($record, array $data) {
        //       $record->availability_status = $data['availability_status'];
        //       $record->save();
        //     })
        // ),
        TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        SelectFilter::make('brand_id')
          ->relationship('brand', 'name'),
        SelectFilter::make('availability_status')
          ->options(VehicleAvailabilityStatus::options()),
      ])
      ->recordActions([
        ActionGroup::make([
          Action::make('mark_as_available')
            ->label('Mark as Available')
            ->icon(Heroicon::CheckCircle)
            ->color(fn() => VehicleAvailabilityStatus::AVAILABLE->getColor())
            ->hidden(fn($record) => $record->availability_status === VehicleAvailabilityStatus::AVAILABLE)
            ->action(function ($record) {
              $record->availability_status = VehicleAvailabilityStatus::AVAILABLE;
              $record->save();
            }),
          Action::make('mark_as_reserved')
            ->label('Mark as Reserved')
            ->icon(Heroicon::Clock)
            ->color(fn() => VehicleAvailabilityStatus::RESERVED->getColor())
            ->hidden(fn($record) => $record->availability_status === VehicleAvailabilityStatus::RESERVED)
            ->action(function ($record) {
              $record->availability_status = VehicleAvailabilityStatus::RESERVED;
              $record->save();
            }),
          Action::make('mark_as_maintenance')
            ->label('Mark as Maintenance')
            ->icon(Heroicon::WrenchScrewdriver)
            ->color(fn() => VehicleAvailabilityStatus::MAINTENANCE->getColor())
            ->hidden(fn($record) => $record->availability_status === VehicleAvailabilityStatus::MAINTENANCE)
            ->action(function ($record) {
              $record->availability_status = VehicleAvailabilityStatus::MAINTENANCE;
              $record->save();
            }),
        ])
          ->label('Change Status')
          ->icon(Heroicon::PencilSquare),
        // ViewAction::make(),
        ActionGroup::make([
          EditAction::make(),
          DeleteAction::make(),
        ])
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
