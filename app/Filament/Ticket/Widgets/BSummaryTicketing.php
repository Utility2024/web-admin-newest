<?php

namespace App\Filament\Ticket\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;

class BSummaryTicketing extends ApexChartWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static string $chartId = 'summaryTicketing';
    protected static ?string $heading = 'Summary Ticketing';

    protected function getOptions(): array
    {
        $user = Auth::user();
        $userId = Auth::id();
        $userRole = $user->role;

        $priorityColors = [
            'Low' => '#6c757d',       // Gray
            'Medium' => '#ffc107',    // Yellow
            'Urgent' => '#dc3545',    // Red
            'Critical' => '#007bff',  // Blue
        ];

        $monthlyTicketCounts = [];
        foreach ($priorityColors as $priority => $color) {
            $monthlyTicketCounts[$priority] = array_fill(0, 12, 0);
        }

        // Get selected year and month from the form state
        $year = $this->form->getState()['year'] ?? now()->year;

        // Query to get ticket count and priorities per month based on role
        if ($userRole === 'USER') {
            $tickets = Ticket::where('created_by', $userId)
                ->whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, priority')
                ->groupBy('month', 'priority')
                ->get();
        } elseif (in_array($userRole, ['MANAGERADMIN', 'SUPERADMIN'])) {
            $tickets = Ticket::whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, priority')
                ->groupBy('month', 'priority')
                ->get();
        } elseif (in_array($userRole, ['ADMINHR', 'ADMINESD', 'ADMINUTILITY', 'ADMINGA'])) {
            $tickets = Ticket::where('assigned_role', $userRole)
                ->whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, priority')
                ->groupBy('month', 'priority')
                ->get();
        } else {
            $tickets = collect();
        }

        foreach ($tickets as $ticket) {
            $monthIndex = $ticket->month - 1;
            $monthlyTicketCounts[$ticket->priority][$monthIndex] = $ticket->count;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
                'stacked' => true,
            ],
            'series' => array_map(function ($priority) use ($monthlyTicketCounts) {
                return [
                    'name' => $priority,
                    'data' => $monthlyTicketCounts[$priority],
                ];
            }, array_keys($priorityColors)),
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => ['style' => ['fontFamily' => 'inherit']],
            ],
            'yaxis' => [
                'labels' => ['style' => ['fontFamily' => 'inherit']],
            ],
            'colors' => array_values($priorityColors),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('year')
                ->options(array_combine(range(now()->year - 5, now()->year), range(now()->year - 5, now()->year)))
                ->default(now()->year)
                ->reactive(),

        ];
    }
}
