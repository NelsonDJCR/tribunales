<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
    use HasFactory;

    public function tipoActividad()
    {
        return $this->hasOne(TipoActividad::class, 'id','id_tipo_actividad');
    }
}
