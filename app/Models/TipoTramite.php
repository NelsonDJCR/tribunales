<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTramite extends Model
{
    protected $connection = 'dinamico';
    protected $table = 'tipo_tramite';
    use HasFactory;
}
