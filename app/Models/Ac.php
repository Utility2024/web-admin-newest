<?php

namespace App\Models;

use App\Models\User;
use App\Models\HistoryAc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ac extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'acs';

    protected $connection = 'mysql_utility';

    // Define the fillable properties
    protected $fillable = [
        'area',
        'equipment_name',
        'equipment_number',
        'location',
        'type',
        'pk_capacity',
        'status',
        'btu',
        'type_freon',
    ];

    public function historyAcs()
    {
        return $this->hasMany(HistoryAc::class);
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
