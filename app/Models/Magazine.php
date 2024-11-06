<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\MagazineDetail;
use Illuminate\Support\Facades\Auth;

class Magazine extends Model
{
    use HasFactory;

    protected $connection = 'mysql_esd'; // Koneksi yang digunakan
    protected $table = 'magazines'; // Nama tabel

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'register_no',
    ];

    public function magazineDetails()
    {
        return $this->hasMany(MagazineDetail::class);
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
