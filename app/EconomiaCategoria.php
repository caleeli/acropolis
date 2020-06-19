<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EconomiaCategoria extends Model
{
    protected $appends = [
        'total',
    ];

    public function getTotalAttribute()
    {
        return $this->diario()
            ->whereGestionActual()
            ->sum(DB::raw('ingreso-egreso'));
    }

    public function scopeWhereTieneDiario($query)
    {
        return $query->withCount(['diario' => function ($q) {
            return $q->whereGestionActual();
        }])->orderBy('diario_count', 'desc');
    }

    public function diario()
    {
        return $this->hasMany(Diario::class, 'cuenta', 'codigo');
    }
}
