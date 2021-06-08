<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    use HasFactory;
    protected $table = 'comisiones';
    protected $fillable = ['consepto', 'valor_honorarios','numero_dias','valor_factura','total_pagar','retefuente','rete_iva','rete_ica','neto_pagar','valor_bruto'];
}
