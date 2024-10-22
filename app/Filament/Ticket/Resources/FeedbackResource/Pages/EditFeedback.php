<?php

namespace App\Filament\Ticket\Resources\FeedbackResource\Pages;

use App\Filament\Ticket\Resources\FeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeedback extends EditRecord
{
    protected static string $resource = FeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
