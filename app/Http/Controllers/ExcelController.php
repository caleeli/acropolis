<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use JDD\Api\Http\Controllers\ApiController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends ApiController
{
    public function excel(Request $request, ...$route)
    {
        $data = $this->index($request, ...$route)->getData();
        $data = json_decode(json_encode($data), true);
        $columns = explode(',', $request->input('columns'));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $titles = ['Fecha', 'Detalle', 'Ingreso', 'Egreso', 'Saldo', 'Recibo', 'Categoria'];
        foreach ($titles as $j => $title) {
            $c = $j + 1;
            $r = 9;
            $sheet->setCellValueByColumnAndRow($c, $r, $title);
            $sheet->getStyleByColumnAndRow($c, $r)
                ->getFont()
                ->setBold(true);
            $sheet->getStyleByColumnAndRow($c, $r)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF94D3A2');
        }

        // RESUMEN
        $r = 1;
        $sheet->setCellValueByColumnAndRow(2, $r, 'DIARIO');
        $sheet->getStyleByColumnAndRow(2, $r)
            ->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ]);

        $r = 3;
        $sheet->setCellValueByColumnAndRow(1, $r, 'Fecha: ');
        $sheet->getStyleByColumnAndRow(1, $r)
            ->applyFromArray([
                'alignment' => ['horizontal' => 'right'],
            ]);
        $sheet->setCellValueByColumnAndRow(2, $r, date('d-m-Y'));
        $sheet->getStyleByColumnAndRow(2, $r)
            ->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ]);
        
        $r = 4;
        $min = $data['data'][0]['attributes']['fecha_f'];
        $max = $data['data'][count($data['data']) - 1]['attributes']['fecha_f'];
        $sheet->setCellValueByColumnAndRow(1, $r, 'Periodo: ');
        $sheet->getStyleByColumnAndRow(1, $r)
            ->applyFromArray([
                'alignment' => ['horizontal' => 'right'],
            ]);
        $sheet->setCellValueByColumnAndRow(2, $r, "del $min al $max");
        $sheet->getStyleByColumnAndRow(2, $r)
            ->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ]);

        $r = 5;
        $sheet->setCellValueByColumnAndRow(1, $r, 'Ingresos: ');
        $sheet->getStyleByColumnAndRow(1, $r)
            ->applyFromArray([
                'alignment' => ['horizontal' => 'right'],
            ]);
        $sheet->setCellValueByColumnAndRow(2, $r, "=SUM(C10:C" . (10 + count($data['data']) - 1) . ")");
        $sheet->getStyleByColumnAndRow(2, $r)
            ->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ]);
        $sheet->getStyleByColumnAndRow(2, $r)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $r = 6;
        $sheet->setCellValueByColumnAndRow(1, $r, 'Egresos: ');
        $sheet->getStyleByColumnAndRow(1, $r)
            ->applyFromArray([
                'alignment' => ['horizontal' => 'right'],
            ]);
        $sheet->setCellValueByColumnAndRow(2, $r, "=SUM(D10:D" . (10 + count($data['data']) - 1) . ")");
        $sheet->getStyleByColumnAndRow(2, $r)
            ->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ]);
        $sheet->getStyleByColumnAndRow(2, $r)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $r = 7;
        $sheet->setCellValueByColumnAndRow(1, $r, 'Saldo: ');
        $sheet->getStyleByColumnAndRow(1, $r)
            ->applyFromArray([
                'alignment' => ['horizontal' => 'right'],
            ]);
        $sheet->setCellValueByColumnAndRow(2, $r, $data['data'][count($data['data']) - 1]['attributes']['saldo']);
        $sheet->getStyleByColumnAndRow(2, $r)
            ->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ]);
        $sheet->getStyleByColumnAndRow(2, $r)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        foreach ($data['data'] as $i => $row) {
            $r = $i + 10;
            foreach ($columns as $j => $column) {
                $c = $j + 1;
                $value = Arr::get($row, $column);
                $sheet->setCellValueByColumnAndRow($c, $r, $value);
                $sheet->getColumnDimensionByColumn($c)->setAutoSize(true);
                if (in_array($c, [3, 4, 5])) {
                    $sheet->getStyleByColumnAndRow($c, $r)
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }
                if (in_array($c, [6])) {
                    $sheet->getStyleByColumnAndRow($c, $r)
                        ->applyFromArray([
                            'alignment' => ['horizontal' => 'right'],
                        ]);
                }
            }
        }
        $sheet->getStyleByColumnAndRow(1, 1, 1, count($data['data']))
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->calculateColumnWidths();

        $writer = new Xlsx($spreadsheet);
        $file = storage_path(uniqid('app/file', true) . '.xlsx');
        $writer->save($file);
        return response()->download($file, 'diario.xlsx');
    }
}
