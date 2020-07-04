<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $gestion
 * @property Carbon $fecha
 * @property string $detalle
 * @property float $ingreso
 * @property float $egreso
 * @property float $saldo
 * @property string $recibo
 * @property string $cuenta
 * @property string $libreta
 * @property int $miembro_id
 */
class Diario extends Model
{
    protected $guarded = [];

    protected $casts = [
        'fecha' => 'date',
    ];

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
