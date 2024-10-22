<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Ticket extends Model
{
    use HasFactory, HasFilamentComments;

    protected $fillable = [
        'title',
        'description',
        'file',
        'status',
        'priority',
        'category_id',
        'assigned_role',
        'approval',
        'approval_at',
        'approval_user',
        'approval_user_at',
        'comment_manager',
        'comments_user',
        'name'
    ];

    protected $dates = [
        'closed_at',
    ];

    protected $casts = [
        'file' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryTicket::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ticket_number = self::generateTicketNumber();
            $model->created_by = Auth::id();
            
            // Set default values for approval and approval_user
            $model->approval = 'Waiting Approval';
            $model->approval_user = 'Waiting Approval';
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();

            if ($model->isDirty('status') && $model->status === 'Closed') {
                $model->closed_at = Carbon::now('Asia/Jakarta');
            } elseif ($model->isDirty('status') && $model->status !== 'Closed') {
                $model->closed_at = null;
            }
        });
    }

    public static function generateTicketNumber()
    {
        $today = Carbon::today()->format('d-m-Y');
        $latestTicket = self::whereDate('created_at', Carbon::today())->latest('id')->first();

        if ($latestTicket) {
            $latestNumber = intval(substr($latestTicket->ticket_number, -4)) + 1;
        } else {
            $latestNumber = 1;
        }

        return sprintf('TC/%s/%04d', $today, $latestNumber);
    }

    public function getFileUrlAttribute()
    {
        return Storage::url($this->photo_before);
    }    

    // Assign ticket to a role
    public function assignToRole($role)
    {
        // Update the assigned_role field
        $this->assigned_role = $role;
        $this->save();
    }
}
