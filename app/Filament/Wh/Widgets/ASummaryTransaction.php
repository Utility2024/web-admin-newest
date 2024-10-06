<?php

namespace App\Filament\Wh\Widgets;

use App\Models\TrayIn;
use App\Models\TrayOut;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ASummaryTransaction extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTrayIn = TrayIn::sum('qty');
        $totalTrayeOut = TrayOut::sum('qty');
        $revenue = $totalTrayIn - $totalTrayeOut;

        return [
            Stat::make('Total Tray In', $totalTrayIn)
                ->color('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->url('/wh/tray-ins'),
            Stat::make('Total Tray Out', $totalTrayeOut)
                ->color('danger')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->url('/wh/tray-outs'),
            Stat::make('Balance',$revenue)
                ->color($revenue >= 0 ? 'success' : 'danger')
                ->description($revenue >= 0 ? 'Up' : 'Down')
                ->descriptionIcon($revenue >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down'),
        ];
    }
}
