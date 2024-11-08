<?php

namespace App\Filament\Production\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\MasterWip; // Make sure to import your model

class AWip extends BaseWidget
{
    protected function getStats(): array
    {
        // Count the different statuses
        $openCount = MasterWip::where('status', 'Open')->count();
        $inProgressCount = MasterWip::where('status', 'In Progress')->count();
        $finishedCount = MasterWip::where('status', 'Finished')->count();

        return [
            Stat::make('Open', $openCount)
                ->url('/production/master-wips?activeTab=Open')
                ->color('danger')
                ->description('Total Model Open')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('In Progress', $inProgressCount)
                ->url('/production/master-wips?activeTab=In+Progress')
                ->color('warning')
                ->description('Total Model In Progress')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Finished', $finishedCount)
                ->url('/production/master-wips?activeTab=Finished')
                ->color('success')
                ->description('Total Model Finished')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
