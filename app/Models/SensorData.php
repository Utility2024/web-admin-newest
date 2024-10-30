<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    protected $table = 'sensor_data';

    protected $connection = 'mysql_utility';

    protected $fillable = ['id', 'temperature', 'humidity', 'status_read_sensor_dht11'];
}
