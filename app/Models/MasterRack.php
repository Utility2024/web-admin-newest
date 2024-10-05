<?php

namespace App\Models;

use App\Models\User;
use App\Models\TrayIn;
use App\Models\TrayOut;
use App\Models\TrayStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterRack extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'master_racks';

    protected $connection = 'mysql_wh';

    protected $fillable = [
        'locator_number',
        'capatity',
        'status',
        'lamp'
    ];

    public function trayStocks()
    {
        return $this->hasMany(TrayStock::class, 'master_racks_id');
    }
    
    public function trayIns()
    {
        return $this->hasMany(TrayIn::class, 'master_racks_id');
    } 
    
    public function trayOuts()
    {
        return $this->hasMany(TrayOut::class, 'master_racks_id');
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
