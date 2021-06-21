<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departamentos;

class Tribunal extends Model
{
    protected $connection = 'dinamico';
    protected $table = 'tribunal';
    use HasFactory;


    public function departamento()
    {
        return $this->hasOne(Departamentos::class, 'id', 'dep_id');
    }

    public function ciudad()
    {
        return $this->hasOne(Ciudad::class, 'id', 'ciu_id');
    }
}
