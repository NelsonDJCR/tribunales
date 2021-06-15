<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    protected $table = 'sorteo';
    use HasFactory;

    public function eleccion()
    {
        return $this->hasOne(TipoEleccion::class, 'id', 'id_tipo_eleccion');
    }
}
