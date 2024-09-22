<?php

namespace App\Filament\Stock\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Filament\Stock\Resources\TransactionResource;

class Transaction extends ApexChartWidget
{
    protected static string $chartId = 'transaction';
    protected static ?string $heading = 'Monthly Transaction';

    protected function getOptions(): array
    {
        $year = now()->year; // Atau gunakan tahun yang diinginkan
        $transactions = TransactionResource::getDataForYearlyChart($year);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 360,
            ],
            'series' => [
                [
                    'name' => 'Transaction',
                    'data' => $transactions,
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
        ];
    }
}
