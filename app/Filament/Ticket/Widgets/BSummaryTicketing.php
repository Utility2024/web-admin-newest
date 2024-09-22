<?php

namespace App\Filament\Ticket\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

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

        // Initialize arrays for ticket counts and colors per priority per month
        $monthlyTicketCounts = [];
        $monthlyColors = [];

        foreach ($priorityColors as $priority => $color) {
            $monthlyTicketCounts[$priority] = array_fill(0, 12, 0);
            $monthlyColors[$priority] = array_fill(0, 12, $color);
        }

        // Query to get ticket count and priorities per month based on role
        if ($userRole === 'USER') {
            $tickets = Ticket::where('created_by', $userId)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, priority')
                ->groupBy('month', 'priority')
                ->get();
        } elseif ($userRole === 'MANAGERADMIN' || $userRole === 'SUPERADMIN') {
            $tickets = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as count, priority')
                ->groupBy('month', 'priority')
                ->get();
        } elseif (in_array($userRole, ['ADMINHR', 'ADMINESD', 'ADMINUTILITY', 'ADMINGA'])) {
            $tickets = Ticket::where('assigned_role', $userRole)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, priority')
                ->groupBy('month', 'priority')
                ->get();
        } else {
            // Default to no data if the role is not recognized
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
                'stacked' => true, // Stack bars for each priority
            ],
            'series' => array_map(function ($priority) use ($monthlyTicketCounts) {
                return [
                    'name' => $priority,
                    'data' => $monthlyTicketCounts[$priority],
                ];
            }, array_keys($priorityColors)),
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
            'colors' => array_values($priorityColors),
        ];
    }
}
