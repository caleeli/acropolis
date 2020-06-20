<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
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
}
