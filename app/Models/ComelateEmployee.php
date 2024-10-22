<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Database\Eloquent\SoftDeletes;

class ComelateEmployee extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $connection = 'mysql_hr';

    protected $fillable = [
        'nik', 
        'name', 
        'department', 
        'shift', 
        'status',
        'alasan_terlambat', 
        'nama_security', 
        'tanggal', 
        'jam',
        'created_by',
        'updated_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'user_login');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set the creator
            $model->created_by = Auth::id();
            
            // Check if nik exists in Employee table
            $exists = DB::connection('mysql_employee')
                ->table('v_employee')
                ->where('user_login', $model->nik)
                ->exists();

            // Set status based on existence
            $model->status = $exists ? 'Active' : 'Tidak Active';
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();

            // Check if nik exists in Employee table
            $exists = DB::connection('mysql_employee')
                ->table('v_employee')
                ->where('user_login', $model->nik)
                ->exists();

            // Set status based on existence
            $model->status = $exists ? 'Active' : 'Tidak Active';
        });
    }
}
