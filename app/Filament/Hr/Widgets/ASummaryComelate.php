<?php

namespace App\Filament\Hr\Widgets;

use App\Models\Employee;
use App\Models\ComelateEmployee;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ASummaryComelate extends BaseWidget
{
    protected function getStats(): array
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has the 'SECURITY' role using the isSecurity() method
        if ($user && $user->isSecurity()) {
            // If the user has the 'SECURITY' role, return an empty array to hide the widget
            return [];
        }

        // If the user does not have the 'SECURITY' role, show the stats
        $totalComelate = ComelateEmployee::count();
        $totalDepartments = Employee::distinct('Departement')->count('Departement');
        $totalEmployee = Employee::count();

        return [
            Stat::make('Total Comelate', $totalComelate)
                ->description('Total jumlah data terlambat'),
            Stat::make('Total Departments', $totalDepartments)
                ->description('Total jumlah department yang terdaftar'),
            Stat::make('Total Employee', $totalEmployee)
                ->description('Total Employee Yang terdaftar dan aktif'),
        ];
    }
}
