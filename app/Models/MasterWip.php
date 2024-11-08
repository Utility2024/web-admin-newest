<?php

namespace App\Models;

use App\Models\User;
use App\Models\DetailWip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterWip extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi plural
    protected $table = 'master_wips';

    protected $connection = 'mysql_production';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'model',
        'dj', 
        'lot_qty', 
        'status',
        'acceptance_status',
        'approval',
        'created_by', 
        'updated_by'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id'); // Ensure 'user_id' is the correct foreign key
    }

    /**
     * Relasi satu ke banyak (One-to-Many) dengan DetailWip
     */
    public function detailWips()
    {
        return $this->hasMany(DetailWip::class, 'master_wips_id');
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
