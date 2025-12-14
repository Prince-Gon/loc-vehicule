<?php

namespace App\Filament\Resources\RentalContracts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentalContractsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('client.first_name')
          ->formatStateUsing(fn($record) => "{$record->client->first_name} {$record->client->last_name}")
          ->searchable(),
        TextColumn::make('vehicle.model')
          ->formatStateUsing(fn($record) => "{$record->vehicle->brand->name} {$record->vehicle->model} ({$record->vehicle->license_plate})")
          ->searchable(),
        TextColumn::make('start_date')
          ->date()
          ->sortable(),
        TextColumn::make('end_date')
          ->date()
          ->sortable(),
        TextColumn::make('total_price')
          ->money('DZD')
          ->sortable(),
        TextColumn::make('status')
          ->formatStateUsing(fn($state) => $state->getLabel())
          ->color(fn($state) => $state->getColor())
          ->badge(),
        TextColumn::make('pdf_path')
          ->searchable(),
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
        //
      ])
      ->recordActions([
        EditAction::make(),
        DeleteAction::make(),
        ViewAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
