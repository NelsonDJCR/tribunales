<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaCobro extends Model
{
    use HasFactory;
    protected $table = 'cuentas_cobro';

    protected $fillable = [
       'id_tribunal',
       'id_magistrado',
       'fecha_inicio',
       'fecha_fin',
       'valor_honorarios',
       'numero_dias',
       'valor_bruto',
       'valor_factura',
       'total_pagar',
       'rete_fuente',
       'rete_iva',
       'rete_ica',
       'neto_pagar',
       'estado',
    ];

    public function tribunal()
    {
        return $this->belongsTo(Tribunal::class, 'id_tribunal');
    }
    public function magistrado()
    {
        return $this->belongsTo(Magistrado::class, 'id_magistrado');
    }
}
