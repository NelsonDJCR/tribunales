<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CasoSeguimiento extends Model
{
    use HasFactory;

    protected $table = 'casos_seguimientos';
    protected $maps = [
        'id_asesor_asignado' => 'asesor',
        'id_estado' => 'estadocaso',
    ];
    protected $appends = ['asesor', 'estadocaso'];
    protected $hidden = ['id', 'id_asesor_asignado', 'id_estado', 'id_caso', 'created_at', 'updated_at'];

    protected $fillable = ['id_caso', 'id_asesor_asignado', 'gestion', 'fecha_gestion'];

    public function getAsesorAttribute()
    {
        return $this->attributes['id_asesor_asignado'];
    }
    public function getEstadocasoAttribute()
    {
        return $this->attributes['id_estado'];
    }
}
