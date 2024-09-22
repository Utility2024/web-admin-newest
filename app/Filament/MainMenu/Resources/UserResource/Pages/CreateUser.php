<?php

namespace App\Filament\MainMenu\Resources\UserResource\Pages;

use App\Filament\MainMenu\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
