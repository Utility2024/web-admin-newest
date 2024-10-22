<?php

namespace App\Models;

use App\Models\Ac;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryAc extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'history_acs';

    protected $connection = 'mysql_utility';

    // Define the fillable properties
    protected $fillable = [
        'acs_id',
        'equipment_name',
        'area',
        'location',
        'type',
        'status',
        'description',
        'photo',
    ];

    /**
     * Define the relationship with the Ac model.
     */
    public function acs()
    {
        return $this->belongsTo(Ac::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the transaction.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Boot method to attach model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Set the creator on creating event
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        // Set the updater on updating event
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
