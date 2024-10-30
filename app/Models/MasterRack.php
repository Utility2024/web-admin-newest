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
    use SoftDeletes, HasFactory;

    protected $table = 'master_racks';
    protected $connection = 'mysql_wh';

    protected $fillable = [
        'locator_number',
        'capacity',
        'status',
        'lamp'
    ];

    // Many-to-many relationship with TrayStock
    public function trayStocks()
    {
        return $this->belongsTo(TrayStock::class,'tray_stock_id');
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

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Boot method to set created_by and updated_by
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
