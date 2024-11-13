<?php

namespace App\Filament\MainMenu\Resources\InboxResource\Pages;

use App\Filament\MainMenu\Resources\InboxResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListInboxes extends ListRecords
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Inbox";
    }

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

        // If the user has 'isManagerAdmin' role, they can see all data
        if ($user->isManagerAdmin()) {
            return parent::getTableQuery(); // Show all data
        }

        // If the user has 'isAdminWip' or 'isUserWip' roles, filter by 'transaction_type'
        if ($user->isAdminWip() || $user->isUserWip()) {
            return parent::getTableQuery()->where('transaction_type', 'master_wips');
        }

        // If the user does not have the above roles, filter by 'user_id'
        return parent::getTableQuery()->where('user_id', $user->id);
    }
}
