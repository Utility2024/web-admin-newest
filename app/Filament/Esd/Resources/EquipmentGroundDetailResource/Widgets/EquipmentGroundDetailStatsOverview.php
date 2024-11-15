<?php

namespace App\Filament\Esd\Resources\EquipmentGroundDetailResource\Widgets;

use App\Models\EquipmentGroundDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card as Stat;

class EquipmentGroundDetailStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = '5';

    protected function getCards(): array
    {
        $totalData = EquipmentGroundDetail::count();

        return [
            Stat::make('Total Data', $totalData)
                ->color('warning')
                ->extraAttributes(['class' => 'col-md-12'])
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
