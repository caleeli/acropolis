<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aporte extends Model
{
    protected $guarded = [];

    protected $casts = [
        'imagen' => 'array',
        'fecha_pago' => 'date',
    ];

    public function scopeConsolidado($query)
    {
        return $query->select([
            DB::raw('max(id) as id'),
            'mes',
            'gestion',
            DB::raw('sum(monto) as monto'),
            DB::raw('min(verificado_por) as verificado'),
        ])->groupBy('gestion', 'mes');
    }

    public function miembro()
    {
        return $this->belongsTo(User::class);
    }
}
