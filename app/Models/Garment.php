<?php

namespace App\Models;

use App\Models\User;
use App\Models\GarmentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Garment extends Model 
{
    use HasFactory;

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
        'Last_Group'
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
    public function garmentDetails()
    {
        return $this->hasMany(GarmentDetail::class, 'nik', 'ID');
    }
}
