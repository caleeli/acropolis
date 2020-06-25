<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Diario extends Model
{
    protected $guarded = [];

    public function scopeWhereGestionActual($query)
    {
        return $query->where('gestion', date('Y'));
    }

    public function scopeWhereCaja($query)
    {
        return $query->where('libreta', 'caja');
    }

    public function scopeWhereCuenta($query)
    {
        return $query->where('libreta', 'cuenta');
    }

    public function scopeNoInicial($query)
    {
        return $query->where('detalle', '!=', 'Saldo Inicial')
            ->where('detalle', '!=', 'Apertura caja');
    }

    public function actualizaSaldo()
    {
        $this->saldo = Diario
            ::where('libreta', $this->libreta)
            ->where('id', '<', $this->id)
            ->sum(DB::raw('ingreso-egreso'))
            + $this->ingreso - $this->egreso;
    }
}
