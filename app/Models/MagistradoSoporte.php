<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagistradoSoporte extends Model
{
    use HasFactory;

    protected $connection = 'dinamico';
    protected $table = 'magistrados_soporte';
}
