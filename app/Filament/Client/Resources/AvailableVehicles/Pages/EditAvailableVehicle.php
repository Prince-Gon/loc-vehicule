<?php

namespace App\Filament\Client\Resources\AvailableVehicles\Pages;

use App\Filament\Client\Resources\AvailableVehicles\AvailableVehicleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAvailableVehicle extends EditRecord
{
    protected static string $resource = AvailableVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
