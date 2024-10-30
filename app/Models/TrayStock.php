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
    use SoftDeletes, HasFactory;

    protected $table = 'tray_stocks';
    protected $connection = 'mysql_wh';

    protected $fillable = [
        'plant_buffer',
        'material',
        'plant',
        'material_description',
        'qty_in',
        'qty_out',
        'qty'
    ];

    protected $casts = [
        'master_racks_id' => 'array',
    ];

    // Accessor for total quantity
    public function getQtyAttribute()
    {
        return $this->qty_in - $this->qty_out;
    }

    // Many-to-many relationship with MasterRack
    public function masterRacks()
    {
        return $this->belongsTo(MasterRack::class, 'master_racks_id');
    }

    // Relations to TrayIn and TrayOut
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
    
    // Boot method to set qty_in, qty_out and created_by or updated_by
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->qty_in = $model->trayIns()->sum('qty');
            $model->qty_out = $model->trayOuts()->sum('qty');
            $model->qty = $model->qty_in - $model->qty_out;
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->qty_in = $model->trayIns()->sum('qty');
            $model->qty_out = $model->trayOuts()->sum('qty');
            $model->qty = $model->qty_in - $model->qty_out;
            $model->updated_by = Auth::id();
        });
    }
}
