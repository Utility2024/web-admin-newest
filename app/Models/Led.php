<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Led extends Model
{
    use HasFactory;

    protected $table = 'led_status';

    protected $connection = 'mysql_utility';

    protected $fillable = [
        'led_01',
        'led_02',
        'led_03',
        'led_04',
    ];
}
