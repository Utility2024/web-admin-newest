<?php

namespace App\Filament\Ticket\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class ATicketingWidgets extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $userId = Auth::id();
        $userRole = $user->role;
        
        $isSuperAdmin = $user->isSuperAdmin();
        $isManagerAdmin = $user->isManagerAdmin();
        $isAdminHr = $user->isAdminHr();
        $isAdminGa = $user->isAdminGa();
        $isAdminUtility = $user->isAdminUtility();
        $isAdminEsd = $user->isAdminEsd();

        $stats = [];

        // Tambahkan statistik 'All' jika pengguna adalah SUPERADMIN atau MANAGERADMIN
        if ($isSuperAdmin || $isManagerAdmin) {
            $stats[] = Stat::make('All Tickets', $this->getCount())
                ->description('Total tickets')
                ->url('http://portal.siix-ems.co.id/ticket/tickets')
                ->color('primary');
        }

        // Tambahkan statistik 'My Tickets' jika pengguna adalah USER
        if ($userRole === 'USER') {
            $stats[] = Stat::make('All My Tickets', $this->getCountMyTickets())
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets')
                ->color('success');

            $stats[] = Stat::make('Open Tickets', $this->getCountByStatus('Open'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Open')
                ->color('warning');

            $stats[] = Stat::make('Pending Tickets', $this->getCountByStatus('Pending'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Pending')
                ->color('danger');

            $stats[] = Stat::make('In Progress Tickets', $this->getCountByStatus('In Progress'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=In+Progress')
                ->color('info');

            $stats[] = Stat::make('Closed Tickets', $this->getCountByStatus('Closed'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Closed')
                ->color('danger');
        }

        // Tambahkan statistik berdasarkan role Admin
        if ($isAdminHr || $isAdminGa || $isAdminUtility || $isAdminEsd) {
            $stats[] = Stat::make('Open Tickets', $this->getCountByRoleAndStatus('Open', $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=Open')
                ->color('warning');

            $stats[] = Stat::make('In Progress Tickets', $this->getCountByRoleAndStatus('In Progress', $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=In+Progress')
                ->color('info');

            $stats[] = Stat::make('Pending Tickets', $this->getCountByRoleAndStatus('Pending', $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=Pending')
                ->color('secondary');

            $stats[] = Stat::make('Closed Tickets', $this->getCountByRoleAndStatus('Closed', $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=Closed')
                ->color('danger');
        }

        // Tambahkan statistik status jika pengguna adalah MANAGERADMIN
        if ($isManagerAdmin) {
            $stats[] = Stat::make('Approved Tickets', $this->getCountByApproval('Approved'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Approved')
                ->color('success');

            $stats[] = Stat::make('Rejected Tickets', $this->getCountByApproval('Rejected'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Rejected')
                ->color('danger');
            
            $stats[] = Stat::make('Waiting Tickets', $this->getCountByApproval('Waiting Approval'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Waiting Approval')
                ->color('warning');
        }

        return $stats;
    }

    private function getCount(): int
    {
        return Ticket::count();
    }

    private function getCountByRoleAndStatus(string $status, string $role): int
    {
        return Ticket::where('status', $status)
            ->where('assigned_role', $role)
            ->count();
    }

    private function getCountByStatus(string $status): int
    {
        return Ticket::where('status', $status)->count();
    }

    private function getCountMyTickets(): int
    {
        return Ticket::where('created_by', Auth::id())->count();
    }

    private function getCountByApproval(string $approvalStatus): int
    {
        return Ticket::where('approval', $approvalStatus)->count();
    }
}
