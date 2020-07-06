<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JDD\Api\Traits\AjaxFilterTrait;

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
    use AjaxFilterTrait;

    protected $guarded = [];

    protected $casts = [
        'fecha' => 'date',
        'ingreso' => 'double',
        'egreso' => 'double',
        'saldo' => 'double',
    ];

    protected $appends = [
        'fecha_f',
    ];

    public function getFechaFAttribute()
    {
        return $this->fecha ? $this->fecha->format('d-m-Y') : '';
    }
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

    public static function seguimiento($cuenta = '', $libreta = null)
    {
        $format = '%Y:%W';
        $query = Diario::select(DB::raw(
            "strftime('{$format}', fecha) as periodo,
                sum(ingreso) as ingresos,
                sum(egreso) as egresos 
            "
        ))
        ->groupBy(DB::raw("strftime('{$format}', fecha)"));
        if ($cuenta) {
            $query->where('cuenta', $cuenta);
        }
        if ($libreta) {
            $query->where('libreta', $libreta);
        }
        $rows = $query->orderBy('periodo')->get();
        $data = [];
        $ingresos = 0;
        $egresos = 0;
        foreach ($rows as $row) {
            $ingresos += $row['ingresos'];
            $egresos += $row['egresos'];
            $data[] = [
                'periodo' => $row['periodo'],
                'ingresos' => $ingresos,
                'egresos' => $egresos,
            ];
        }
        return $data;
    }

    public function aporte()
    {
        return $this->hasOne(Aporte::class);
    }
}
