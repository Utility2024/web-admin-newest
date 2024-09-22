<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComelateEmployee extends Model
{
    use SoftDeletes;
    use HasFactory;

    // Menggunakan koneksi database 'mysql_hr'
    protected $connection = 'mysql_hr';

    // Daftar kolom yang dapat diisi
    protected $fillable = [
        'nik', 
        'name', 
        'department', 
        'shift', 
        'alasan_terlambat', 
        'nama_security', 
        'tanggal', 
        'jam',
        'created_by',
        'updated_by'
    ];

    /**
     * Relasi ke model User (pembuat)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke model User (pengubah terakhir)
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relasi ke model Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'user_login');
    }

    /**
     * Boot method untuk mengatur event pada model.
     */
    protected static function boot()
    {
        parent::boot();

        // Menentukan pembuat pada event creating
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        // Menentukan pengubah pada event updating
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
