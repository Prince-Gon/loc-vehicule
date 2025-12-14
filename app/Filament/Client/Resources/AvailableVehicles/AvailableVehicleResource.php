<?php

namespace App\Filament\Client\Resources\AvailableVehicles;

use App\Filament\Client\Resources\AvailableVehicles\Pages\CreateAvailableVehicle;
use App\Filament\Client\Resources\AvailableVehicles\Pages\EditAvailableVehicle;
use App\Filament\Client\Resources\AvailableVehicles\Pages\ListAvailableVehicles;
use App\Filament\Client\Resources\AvailableVehicles\Schemas\AvailableVehicleForm;
use App\Filament\Client\Resources\AvailableVehicles\Tables\AvailableVehiclesTable;
use App\Models\Vehicle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AvailableVehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $recordTitleAttribute = 'Vehicle';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return AvailableVehicleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AvailableVehiclesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAvailableVehicles::route('/'),
            // 'create' => CreateAvailableVehicle::route('/create'),
            // 'edit' => EditAvailableVehicle::route('/{record}/edit'),
        ];
    }
}
