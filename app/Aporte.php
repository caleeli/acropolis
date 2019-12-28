<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aporte extends Model
{
    public function scopeConsolidado($query)
    {
        return $query->select([
            DB::raw('max(id) as id'),
            'mes',
            'gestion',
            DB::raw('sum(monto) as monto')
        ])->groupBy('gestion', 'mes');
    }
}
