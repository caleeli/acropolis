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

    /**
     * Importar datos a la tabla de aportes
     *
     * @return void
     */
    public static function importar($excel)
    {
        $reader = new Xls();
        $spreadsheet = $reader->load(public_path('/storage/' . $excel['path']));
        foreach($spreadsheet->getAllSheets() as $sheet) {
            $ene = $sheet->getCell('G2')->getValue();
            if ($ene === 'ENE') {
                $gestion = $sheet->getTitle();
            }
        }
        $sheet = $spreadsheet->getSheet(1);
        return $sheet->getCell('D2')->getValue();
    }
}
