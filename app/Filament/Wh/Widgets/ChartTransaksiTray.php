<?php

namespace App\Filament\Wh\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\TrayIn;
use App\Models\TrayOut;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class ChartTransaksiTray extends ApexChartWidget
{
    protected int|string|array $columnSpan = 'full';
    /**
     * 
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'chartTransaksiTray';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'In & Out Activity Tray WH';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $selectedYear = $this->filterFormData['year'] ?? date('Y'); // Default ke tahun sekarang jika tidak dipilih

        // Ambil data tray_in dan tray_out per bulan untuk tahun yang dipilih
        $trayInData = TrayIn::whereYear('created_at', '=', $selectedYear)
            ->select(DB::raw('MONTH(created_at) as month, SUM(qty) as total_qty'))
            ->groupBy('month')
            ->pluck('total_qty', 'month')
            ->toArray();

        $trayOutData = TrayOut::whereYear('created_at', '=', $selectedYear)
            ->select(DB::raw('MONTH(created_at) as month, SUM(qty) as total_qty'))
            ->groupBy('month')
            ->pluck('total_qty', 'month')
            ->toArray();

        // Siapkan data dengan nilai default 0 jika tidak ada transaksi pada bulan tersebut
        $months = range(1, 12); // Jan sampai Des
        $trayInSeries = [];
        $trayOutSeries = [];

        foreach ($months as $month) {
            $trayInSeries[] = $trayInData[$month] ?? 0;
            $trayOutSeries[] = $trayOutData[$month] ?? 0;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Tray In',
                    'data' => $trayInSeries,
                ],
                [
                    'name' => 'Tray Out',
                    'data' => $trayOutSeries,
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
            'colors' => ['#10b981', '#ef4444'], // Hijau untuk Tray In, Merah untuk Tray Out
        ];
    }

    /**
     * Form schema for filtering data
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [

            // Filter berdasarkan tahun
            Select::make('year')
                ->label('Year')
                ->options([
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    // Tambahkan tahun lainnya jika diperlukan
                ])
                ->default('2024'),
        ];
    }
}
