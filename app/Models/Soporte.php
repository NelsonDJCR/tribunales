<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    use HasFactory;

    protected $connection = 'dinamico';
    protected $table = 'caso_soporte';

    public $timestamps = false;

    public function documento()
    {
        return $this->hasOne(Documento::class, 'id', 'id_documento');
    }
}
