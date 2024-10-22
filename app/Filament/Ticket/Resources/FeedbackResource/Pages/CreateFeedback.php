<?php

namespace App\Filament\Ticket\Resources\FeedbackResource\Pages;

use App\Filament\Ticket\Resources\FeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFeedback extends CreateRecord
{
    protected static string $resource = FeedbackResource::class;
}
