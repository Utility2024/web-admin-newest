<?php

namespace App\Models;

use App\Models\User;
use App\Models\TrayIn;
use App\Models\TrayOut;
use App\Models\MasterRack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrayStock extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'tray_stocks';

    protected $connection = 'mysql_wh';

    protected $fillable = [
        'plant_buffer',
        'material',
        'plant',
        'material_description',
        'master_racks_id',
        'qty_in',
        'qty_out',
        'qty',
    ];

    // Accessor for total quantity
    public function getQtyAttribute()
    {
        return $this->qty_in - $this->qty_out;
    }

    // Method to calculate qty_in and qty_out before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->qty_in = $model->trayIns()->sum('qty');
            $model->qty_out = $model->trayOuts()->sum('qty');
            $model->qty = $model->qty_in - $model->qty_out; // Calculate qty
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->qty_in = $model->trayIns()->sum('qty');
            $model->qty_out = $model->trayOuts()->sum('qty');
            $model->qty = $model->qty_in - $model->qty_out; // Calculate qty
            $model->updated_by = Auth::id();
        });
    }

    public function masterRacks()
    {
        return $this->belongsTo(MasterRack::class, 'master_racks_id');
    }   

    public function trayIns()
    {
        return $this->hasMany(TrayIn::class);
    } 
    
    public function trayOuts()
    {
        return $this->hasMany(TrayOut::class);
    }  

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
