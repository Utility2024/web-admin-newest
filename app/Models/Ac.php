<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ac extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'acs';

    protected $connection = 'mysql_utility';

    // Define the fillable properties
    protected $fillable = [
        'area',
        'equipment_name',
        'equipment_number',
        'location',
    ];
}
