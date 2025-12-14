<?php

namespace App\Filament\Client\Resources\AvailableVehicles\Pages;

use App\Filament\Client\Resources\AvailableVehicles\AvailableVehicleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAvailableVehicles extends ListRecords
{
    protected static string $resource = AvailableVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
