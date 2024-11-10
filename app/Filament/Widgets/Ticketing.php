<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Models\Employee;
use App\Models\DataFasilitas;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Ticketing extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total karyawan
        $totalEmployee = Employee::count();

        $stats[] = Stat::make('Total Employee', $totalEmployee)
            ->icon('heroicon-o-user-group')
            ->description('More Info')
            ->url('/hr/employees')
            ->descriptionIcon('heroicon-m-arrow-right-end-on-rectangle')
            ->color('warning');

        // Menghitung total jobs dari sesi
        $totalJobs = session('total_jobs', 0);

        $stats[] = Stat::make('Total Jobs Akses', $totalJobs)
            ->icon('heroicon-o-document-text')
            ->description('More Info')
            ->url('/admin/jobs')
            ->descriptionIcon('heroicon-m-arrow-right-end-on-rectangle')
            ->color('info');

        // Menghitung total tiket dari model Ticket
        $totalTickets = Ticket::count();

        $stats[] = Stat::make('Total Ticket', $totalTickets)
            ->icon('heroicon-o-ticket')
            ->description('More Info')
            ->url('/admin/tickets')
            ->descriptionIcon('heroicon-m-arrow-right-end-on-rectangle')
            ->color('success');

        // Menghitung total fasilitas dari model DataFasilitas
        $totalFasilitas = DataFasilitas::count();

        $stats[] = Stat::make('Total Assets', $totalFasilitas)
            ->icon('heroicon-o-archive-box')
            ->description('More Info')
            ->url('/ga/')
            ->descriptionIcon('heroicon-m-arrow-right-end-on-rectangle')
            ->color('danger');

        return $stats;
    }
}
