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
    ];

    // Define relationship to the Ticket model
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Define relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
