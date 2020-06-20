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
        return $query->withCount(['diario as suma' => function ($q) {
            return $q->select(DB::raw('sum(ingreso+egreso) as suma'))->whereGestionActual();
        }])->orderBy('suma', 'desc');
    }

    public function diario()
    {
        return $this->hasMany(Diario::class, 'cuenta', 'codigo');
    }
}
