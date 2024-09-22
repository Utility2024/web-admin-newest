<?php

namespace App\Filament\Hr\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\ComelateEmployee;
use Illuminate\Support\Facades\Auth;

class DepartmentSummary extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'departmentSummary';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Department Summary Comelate';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has the 'SECURITY' role using the isSecurity() method
        if ($user && $user->isSecurity()) {
            // If the user has the 'SECURITY' role, return empty chart data
            return [
                'chart' => [
                    'type' => 'donut',
                    'height' => 300,
                ],
                'series' => [],
                'labels' => [],
                'legend' => [
                    'labels' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ];
        }

        // If the user does not have the 'SECURITY' role, show the chart
        $departments = ComelateEmployee::select('department')
            ->selectRaw('count(*) as total')
            ->groupBy('department')
            ->get();

        // Create series and labels from the query results
        $series = $departments->pluck('total')->toArray();
        $labels = $departments->pluck('department')->toArray();

        // Combine department names and counts for labels
        $displayLabels = $departments->map(function ($department) {
            return $department->department . ' (' . $department->total . ')';
        })->toArray();

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 325,
            ],
            'series' => $series,
            'labels' => $displayLabels,
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
