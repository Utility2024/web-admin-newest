<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'status',
        'comments',
        'photo',
        'email_user',
    ];

    protected $casts = [
        'photo' => 'array',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id'); // Pastikan 'ticket_id' adalah foreign key yang benar
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Pastikan 'user_id' adalah foreign key yang benar
    }

    protected static function boot(): void
    {
        parent::boot();

        static::updating(function ($feedback) {
            // Update status di model Ticket berdasarkan status feedback terbaru
            $feedback->ticket()->update(['status' => $feedback->status]);
        });
    }
}
