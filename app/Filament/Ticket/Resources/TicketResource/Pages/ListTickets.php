<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use App\Filament\Ticket\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Filament\Ticket\Resources\TicketResource\RelationManagers\FeedbackRelationManager;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(), // Semua pengguna dapat melihat tombol Create
        ];
    }

    public function getTabs(): array
    {
        $user = Auth::user();
        $userId = $user->id; // Mendapatkan ID pengguna saat ini
        $userRole = $user->role; // Mendapatkan peran pengguna saat ini

        $tabs = [];

        // Tambahkan tab 'All' jika pengguna adalah SUPERADMIN atau MANAGERADMIN
        if ($user->isSuperAdmin() || $user->isManagerAdmin()) {
            $tabs['All'] = Tab::make()
                ->badge($this->getCount()) // Tambahkan badge dengan total count
                ->modifyQueryUsing(fn (Builder $query) => $query);
        }

        // Tambahkan tab 'My Ticket' jika pengguna adalah USER
        if ($user->isUser()) {
            $tabs['My Ticket'] = Tab::make()
                ->badge($this->getCountMyTickets())
                ->icon('heroicon-m-bell')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_by', $userId));
            
            // Tambahkan tabs status jika pengguna adalah USER
            $tabs['Open'] = Tab::make()
                ->badge($this->getCountByStatus('Open'))
                ->icon('heroicon-m-arrow-right-start-on-rectangle')
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('status', 'Open')
                          ->where('created_by', $userId)
                );
            
            $tabs['Pending'] = Tab::make()
                ->badge($this->getCountByStatus('Pending'))
                ->icon('heroicon-m-arrow-path')
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('status', 'Pending')
                          ->where('created_by', $userId)
                );
        
            $tabs['In Progress'] = Tab::make()
                ->badge($this->getCountByStatus('In Progress'))
                ->badgeColor('info')
                ->icon('heroicon-m-backward')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('status', 'In Progress')
                          ->where('created_by', $userId)
                );
        
            $tabs['Closed'] = Tab::make()
                ->badge($this->getCountByStatus('Closed'))
                ->badgeColor('success')
                ->icon('heroicon-m-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('status', 'Closed')
                          ->where('created_by', $userId)
                );
        }

        // Tambahkan tab 'Assigned To My Section' jika pengguna adalah ADMIN dan bukan USER, SUPERADMIN, atau MANAGERADMIN
        if (!in_array($userRole, ['USER', 'SUPERADMIN', 'MANAGERADMIN'])) {
            $tabs['Assigned To My Section'] = Tab::make()
                ->badge($this->getCountAssignedToRole($userRole))
                ->icon('heroicon-m-arrow-right-start-on-rectangle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assigned_role', $userRole));
        }

        // Tambahkan tabs 'Approved' dan 'Rejected' jika pengguna adalah MANAGER ADMIN
        if ($user->isManagerAdmin()) {
            $tabs['Approved'] = Tab::make()
                ->badge($this->getCountByApproval('Approved'))
                ->badgeColor('success')
                ->icon('heroicon-m-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('approval', 'Approved')
                );

            $tabs['Rejected'] = Tab::make()
                ->badge($this->getCountByApproval('Rejected'))
                ->badgeColor('danger')
                ->icon('heroicon-m-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('approval', 'Rejected')
                );
            
            $tabs['Waiting Approval'] = Tab::make()
                ->badge($this->getCountByApproval('Waiting Approval'))
                ->badgeColor('warning')
                ->icon('heroicon-m-arrow-path-rounded-square')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('approval', 'Waiting Approval')
                );
        }

        return $tabs;
    }

    private function getCount(): int
    {
        return $this->getResource()::getModel()::count();
    }

    private function getCountAssignedToRole(string $role): int
    {
        return $this->getResource()::getModel()::where('assigned_role', $role)->count();
    }

    private function getCountMyTickets(): int
    {
        $userId = Auth::id(); // Mendapatkan ID pengguna saat ini
        return $this->getResource()::getModel()::where('created_by', $userId)->count();
    }

    private function getCountByStatus(string $status): int
    {
        return $this->getResource()::getModel()::where('status', $status)->count();
    }

    private function getCountByApproval(string $approvalStatus): int
    {
        return $this->getResource()::getModel()::where('approval', $approvalStatus)->count();
    }
}
