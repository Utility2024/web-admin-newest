<?php

namespace App\Models;

use App\Models\User;
use App\Models\MasterWip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailWip extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi plural
    protected $table = 'detail_wips';

    protected $connection = 'mysql_production';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'master_wips_id', 
        'qty', 
        'acm', 
        'balance',
        'status', 
        'no_hu', 
        'remarks', 
        'created_by', 
        'updated_by'
    ];

    /**
     * Relasi kebalikannya (Many-to-One) dengan MasterWip
     */
    public function masterWip()
    {
        return $this->belongsTo(MasterWip::class, 'master_wips_id');
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
