<?php

namespace App\Filament\Ticket\Resources\TicketResource;

use Filament\Widgets\Widget;

class BCWarningTicket extends Widget
{
    protected static string $view = 'filament.ticket.warning-ticket';

    protected int | string | array $columnSpan = 'full';

    public function getColumnSpan(): string | array | int
    {
        // Mengatur agar widget menggunakan lebar penuh (full width) jika diperlukan
        return 'full';
    }

    public function isFullWidth(): bool
    {
        // Mengatur agar widget menggunakan lebar penuh
        return true;
    }
}
