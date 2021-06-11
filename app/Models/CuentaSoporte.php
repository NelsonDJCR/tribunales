<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaSoporte extends Model
{
    use HasFactory;

    protected $connection = 'dinamico';
    protected $table = 'cuenta_soporte';
}
