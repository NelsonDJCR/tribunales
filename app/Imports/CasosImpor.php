<?php

namespace App\Imports;

use App\Caso;
use FontLib\TrueType\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class CasosImpor
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
    }
}
