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

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

        // Jika user memiliki role isManagerAdmin, mereka dapat melihat semua data
        if ($user->isManagerAdmin()) {
            return parent::getTableQuery(); // Menampilkan semua data
        }

        // Jika bukan isManagerAdmin, filter berdasarkan user_id
        return parent::getTableQuery()->where('user_id', $user->id);
    }
}
