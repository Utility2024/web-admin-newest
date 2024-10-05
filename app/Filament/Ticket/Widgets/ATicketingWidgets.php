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
        $user = Auth::user(); // Get the currently authenticated user
        $userId = Auth::id(); // Get the ID of the authenticated user
        $userRole = $user->role; // Assuming the user role is stored in the 'role' attribute
        
        // Role checks
        $isSuperAdmin = $user->isSuperAdmin();
        $isManagerAdmin = $user->isManagerAdmin();
        $isAdminHr = $user->isAdminHr();
        $isAdminGa = $user->isAdminGa();
        $isAdminUtility = $user->isAdminUtility();
        $isAdminEsd = $user->isAdminEsd();

        $stats = []; // Initialize the stats array

        // Add 'All Tickets' stat if user is SUPERADMIN or MANAGERADMIN
        if ($isSuperAdmin || $isManagerAdmin) {
            $stats[] = Stat::make('All Tickets', $this->getCount())
                ->description('Total tickets')
                ->url('http://portal.siix-ems.co.id/ticket/tickets')
                ->color('primary');
        }

        // Add 'My Tickets' stats if user is a regular USER
        if ($userRole === 'USER') {
            $stats[] = Stat::make('All My Tickets', $this->getCountMyTickets())
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets')
                ->color('success');

            $stats[] = Stat::make('Open Tickets', $this->getCountByCreatedByAndStatus('Open', $userId))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Open')
                ->color('warning');

            $stats[] = Stat::make('Pending Tickets', $this->getCountByCreatedByAndStatus('Pending', $userId))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Pending')
                ->color('danger');

            $stats[] = Stat::make('In Progress Tickets', $this->getCountByCreatedByAndStatus('In Progress', $userId))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=In+Progress')
                ->color('info');

            $stats[] = Stat::make('Closed Tickets', $this->getCountByCreatedByAndStatus('Closed', $userId))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Closed')
                ->color('danger');
        }

        // Add stats for Admin roles
        if ($isAdminHr || $isAdminGa || $isAdminUtility || $isAdminEsd) {
            $stats[] = Stat::make('Open Tickets', $this->getCountByCreatedByAndRoleAndStatus('Open', $userId, $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=Open')
                ->color('warning');

            $stats[] = Stat::make('In Progress Tickets', $this->getCountByCreatedByAndRoleAndStatus('In Progress', $userId, $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=In+Progress')
                ->color('info');

            $stats[] = Stat::make('Pending Tickets', $this->getCountByCreatedByAndRoleAndStatus('Pending', $userId, $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=Pending')
                ->color('secondary');

            $stats[] = Stat::make('Closed Tickets', $this->getCountByCreatedByAndRoleAndStatus('Closed', $userId, $userRole))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?tableFilters[status][value]=Closed')
                ->color('danger');
        }

        // Add approval stats if user is MANAGERADMIN
        if ($isManagerAdmin) {
            $stats[] = Stat::make('Approved Tickets', $this->getCountByCreatedByAndApproval($userId, 'Approved'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Approved')
                ->color('success');

            $stats[] = Stat::make('Rejected Tickets', $this->getCountByCreatedByAndApproval($userId, 'Rejected'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Rejected')
                ->color('danger');
            
            $stats[] = Stat::make('Waiting Tickets', $this->getCountByCreatedByAndApproval($userId, 'Waiting Approval'))
                ->description('More Info')
                ->url('http://portal.siix-ems.co.id/ticket/tickets?activeTab=Waiting Approval')
                ->color('warning');
        }

        return $stats; // Return the compiled stats array
    }

    private function getCount(): int
    {
        return Ticket::count(); // Return total count of tickets
    }

    private function getCountByCreatedByAndStatus(string $status, int $userId): int
    {
        return Ticket::where('status', $status)
            ->where('created_by', $userId)
            ->count(); // Return count of tickets created by the user with the given status
    }

    private function getCountByCreatedByAndRoleAndStatus(string $status, int $userId, string $role): int
    {
        return Ticket::where('status', $status)
            ->where('created_by', $userId)
            ->where('assigned_role', $role)
            ->count(); // Return count of tickets created by the user with the given role and status
    }

    private function getCountByCreatedByAndApproval(int $userId, string $approvalStatus): int
    {
        return Ticket::where('created_by', $userId)
            ->where('approval', $approvalStatus)
            ->count(); // Return count of tickets created by the user with the given approval status
    }

    private function getCountMyTickets(): int
    {
        return Ticket::where('created_by', Auth::id())->count(); // Return count of tickets created by the logged-in user
    }
}
