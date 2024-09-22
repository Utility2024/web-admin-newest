<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanFasilitas extends Model
{
    use HasFactory;

    // Tentukan connection yang digunakan (mysql_ga)
    protected $connection = 'mysql_ga';

    // Nama tabel
    protected $table = 'pengajuan_fasilitas';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'jenis_pengajuan_fasilitas',
        'nik',
        'name',
        'dept',
        'jenis_fasilitas',
        'nomor_identitas_fasilitas',
        'foto_fasilitas',
        'foto_lokasi_fasilitas',
        'lokasi',
        'alasan_pengajuan',
        'due_date',
        'remarks',
        'created_by',
        'updated_by'
    ];

    // Optional: Jika menggunakan timestamp default, kamu bisa menambahkan format yang sesuai
    protected $dates = ['due_date'];
    
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
