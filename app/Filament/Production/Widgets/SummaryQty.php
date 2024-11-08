<?php

namespace App\Filament\Production\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\MasterWip;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class SummaryQty extends ApexChartWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static string $chartId = 'summaryQty';
    
    protected static ?string $heading = 'Summary Lot Qty';

    protected string $dateStart; // Start date for filtering
    protected string $dateEnd; // End date for filtering

    public function __construct()
    {
        // Set the default date range to the start and end of the current month
        $this->dateStart = Carbon::now()->startOfMonth()->toDateString(); // First day of the month
        $this->dateEnd = Carbon::now()->endOfMonth()->toDateString();     // Last day of the month
    }

    protected function getFormSchema(): array
    {
        return [

            DatePicker::make('date_start')
                ->default($this->dateStart)
                ->required(),

            DatePicker::make('date_end')
                ->default($this->dateEnd)
                ->required(),
        ];
    }

    protected function getOptions(): array
    {
        // Use the date range selected by the user
        $data = $this->getLotQtySummary($this->dateStart, $this->dateEnd);
        
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Lot Qty',
                    'data' => $data['daily_totals'],
                ],
            ],
            'xaxis' => [
                'categories' => $data['days'],
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

    protected function getLotQtySummary(string $startDate, string $endDate): array
    {
        // Create Carbon instances for the start and end dates
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Initialize an array to hold daily totals
        $dailyTotals = [];
        $days = [];

        // Loop through the date range to prepare the daily totals
        for ($date = $start->copy(); $date->lessThanOrEqualTo($end); $date->addDay()) {
            $dailyTotals[$date->format('d')] = 0; // Initialize the day with 0
            $days[] = $date->format('d'); // Collect days for x-axis
        }

        // Fetch lot quantities for the specified date range
        $records = MasterWip::whereBetween('created_at', [$start, $end])
            ->get();

        // Summarize lot_qty by day
        foreach ($records as $record) {
            $day = Carbon::parse($record->created_at)->format('d');
            $dailyTotals[$day] += $record->lot_qty;
        }

        return [
            'daily_totals' => array_values($dailyTotals),
            'days' => $days,
        ];
    }
}
