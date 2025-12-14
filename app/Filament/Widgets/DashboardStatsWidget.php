<?php

namespace App\Filament\Widgets;

use App\Enum\RentalContractStatus;
use App\Enum\VehicleAvailabilityStatus;
use App\Models\RentalContract;
use App\Models\Vehicle;
use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Widgets';
    protected ?string $pollingInterval = '5m';
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $available = Vehicle::where('availability_status', VehicleAvailabilityStatus::AVAILABLE->value)->count();

        $active = RentalContract::where('status', RentalContractStatus::ACTIVE->value)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();

        $expiredThisMonth = RentalContract::where('status', RentalContractStatus::EXPIRED->value)
            ->whereBetween('end_date', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()])
            ->count();

        return [
            Stat::make('Available cars', $available)
                ->icon(Heroicon::OutlinedTruck)
                ->color('success'),

            Stat::make('Active contracts', $active)
                ->icon(Heroicon::OutlinedClipboardDocumentList)
                ->color('success'),

            Stat::make('Expired contracts in this current month', $expiredThisMonth)
                ->icon(Heroicon::OutlinedCalendarDays)
                ->color('danger'),
        ];
    }
}
