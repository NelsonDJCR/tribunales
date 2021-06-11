<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadSoporte extends Model
{
    use HasFactory;

    protected $connection = 'dinamico';
    protected $table = 'actividades_soporte';
}
