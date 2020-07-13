<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Aporte extends Model
{
    protected $guarded = [];

    protected $casts = [
        'imagen' => 'array',
        'fecha' => 'date',
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
        return $this->belongsTo(Miembro::class);
    }

    /**
     * Importar datos a la tabla de aportes
     *
     * @return void
     */
    public static function importar($excel)
    {
        $log = '';
        $reader = new Xls();
        $spreadsheet = $reader->load(public_path('/storage/' . $excel['path']));
        $pagos = [];
        $pendiente2017 = [];
        $gestiones = 0;
        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $ene = $sheet->getCell('G2')->getValue();
            if ($ene === 'ENE') {
                $gestion = $sheet->getTitle();
                $gestiones++;
                for ($row = 4;$row < 100;$row++) {
                    $name = trim($sheet->getCell("C{$row}")->getValue());
                    $isName = static::isName($name);
                    if ($isName) {
                        // Pendiente de 2017
                        if ($gestion == '2018') {
                            $pendiente2017[$name] = floatval($sheet->getCell("D{$row}")->getCalculatedValue());
                        }
                        // a cuenta
                        $pagos[$name][] = floatval($sheet->getCell("E{$row}")->getCalculatedValue());
                        floatval($sheet->getCell("E{$row}")->getCalculatedValue());
                        for ($m = 0;$m < 12;$m++) {
                            $col = static::toColumn(7 + $m * 2);
                            $pagos[$name][sprintf('%04d-%02d', $gestion, $m + 1)] = [
                                $gestion,
                                $m + 1,
                                floatval($sheet->getCell("{$col}{$row}")->getCalculatedValue())
                            ];
                        }
                    }
                }
            }
        }
        ksort($pagos);
        // Calcula la moda de los pagos
        $aporteMensual = [];
        foreach ($pagos as $nombre => $pp) {
            $moda = [];
            ksort($pp);
            $pagos[$nombre] = $pp;
            foreach ($pp as $pago) {
                if ($pago[2]) {
                    isset($moda[$pago[2]]) ? $moda[$pago[2]]++ : $moda[$pago[2]] = 1;
                }
            }
            arsort($moda);
            reset($moda);
            $aporteMensual[$nombre] = key($moda);
        }
        // Prepara resumen final
        $resumen = [];
        foreach ($pagos as $nombre => $pp) {
            $aporte = $aporteMensual[$nombre];
            //$log .= "  $nombre: " . array_sum($pp) . '/' . ($aporte * 12 * $gestiones + @$pendiente2017[$nombre]) . " ($aporte)\n";
            $aportes = [
                [
                    'mes' => 12,
                    'gestion' => 2017,
                    'a_pagar' => $pendiente2017[$nombre] ?? 0,
                    'monto' => 0,
                ],
            ];
            foreach ($pp as $pago) {
                if ($pago[2]) {
                    isset($moda[$pago[2]]) ? $moda[$pago[2]]++ : $moda[$pago[2]] = 1;
                }
            }
            $resumen[] = [
                'name' => $nombre,
                'aporte_mensual' => $aporteMensual[$nombre],
                'aportes' => $aportes,
            ];
        }
        return $resumen;
    }

    private static function isName($name)
    {
        return strlen($name) > 4 && strpos($name, ' ') > 0;
    }

    private static function toColumn($number)
    {
        return ($number > 26 ? chr(64 + floor(($number - 1) / 26)) : '') . chr(65 + ($number - 1) % 26);
    }
}
