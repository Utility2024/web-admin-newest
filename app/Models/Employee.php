<?php

namespace App\Models;

use App\Models\PengajuanFasilitas;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Menggunakan koneksi database 'mysql_employee'
    protected $connection = 'mysql_employee';

    // Nama view yang digunakan
    protected $table = 'v_employee';

    // Kolom yang dapat diisi
    protected $fillable = [
        'ID',
        'Departement',
        'Display_Name',
        'user_login',
        'Last_Jobs',
        'Last_Route'
    ];

    // Primary key
    protected $primaryKey = 'ID';

    // Menonaktifkan timestamps karena model ini menggunakan view
    public $timestamps = false;

    // Membuat model ini bersifat read-only
    public function setAttribute($key, $value)
    {
        return null;
    }

    /**
     * Relasi ke model ComelateEmployee
     */
    public function comelateEmployees()
    {
        return $this->hasMany(ComelateEmployee::class, 'nik', 'user_login');
    }

    public function pengajuanFasilitas()
    {
        return $this->hasMany(PengajuanFasilitas::class, 'nik', 'user_login');
    }
}
