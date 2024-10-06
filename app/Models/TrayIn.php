<?php

namespace App\Models;

use App\Models\User;
use App\Models\TrayStock;
use App\Models\MasterRack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrayIn extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $connection = 'mysql_wh';

    protected $table = 'tray_ins';

    protected $fillable = [
        'tray_stock_id',
        'master_racks_id',
        'qty',
    ];

    public function trayStock()
    {
        return $this->belongsTo(TrayStock::class);
    }

    public function masterRacks()
    {
        return $this->belongsTo(MasterRack::class, 'master_racks_id');
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
