<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComelateCount extends Model
{
    use HasFactory;

    // Menggunakan koneksi database 'mysql_employee'
    protected $connection = 'mysql_hr';

    // Nama view yang digunakan
    protected $table = 'view_comelate_employee_counts';

    // Kolom yang dapat diisi
    protected $fillable = [
        'id',
        'nik',
        'name',
        'department',
        'count_comelate',
    ];
}
