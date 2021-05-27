<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaCobro extends Model
{
    protected $table = 'cuentas_cobro';
    use HasFactory;
    public function tribunal()
    {
        return $this->belongsTo(Tribunal::class, 'id_tribunal');
    }
    public function magistrado()
    {
        return $this->belongsTo(Magistrado::class, 'id_magistrado');
    }
}
