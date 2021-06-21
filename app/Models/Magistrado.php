<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magistrado extends Model
{
    protected $table = 'magistrados';
    use HasFactory;

    public function departamento()
    {
        return $this->hasOne(Departamentos::class, 'id', 'dep_id');
    }

    public function ciudad()
    {
        return $this->hasOne(Ciudad::class, 'id','ciu_id');
    }

    public function tipo_identificacion()
    {
        return $this->hasOne(TipoIdentificacion::class, 'id', 'id_tipo_identificacion');
    }

    public function tipo_cuenta()
    {
        return $this->hasOne(TipoCuenta::class, 'id', 'id_tipo_cuenta');
    }

    public function banco()
    {
        return $this->hasOne(Banco::class, 'id', 'id_banco');
    }

    public function tribunal()
    {
        return $this->hasOne(Tribunal::class, 'id', 'tribunal_id');
    }
}
