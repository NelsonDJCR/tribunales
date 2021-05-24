<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CasoSeguimiento;


class Caso extends Model
{
    use HasFactory;
    protected $table = 'casos';


    public function caso() {
        return $this->hasMany(CasoSeguimiento::class, 'id_caso', 'id');
    }
}
