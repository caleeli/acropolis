<?php

use App\Aporte;
use App\AvatarGenerator\RandomAvatar;
use App\Diario;
use App\EconomiaCategoria;
use App\Miembro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EconomiaCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EconomiaCategoria::create([
            'nombre' => 'Cuota mensual de miembros',
            'codigo' => 'CT',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-calendar',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Ingresos Probacionistas',
            'codigo' => 'PR',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-user',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Donaciones extraordinarias de miembros',
            'codigo' => 'DONA',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-donate',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Donaciones de D.N. o J.Filial',
            'codigo' => 'DD',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-donate',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Cursos/cursillos/seminarios',
            'codigo' => 'CR',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-book-reader',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Actividades culturales',
            'codigo' => 'AC',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-theater-masks',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Donaciones o auspicios',
            'codigo' => 'DA',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-donate',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Cafetería',
            'codigo' => 'CO',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-coffee',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Producción Artesanal',
            'codigo' => 'PA',
            'tipo' => 'ingreso',
            'icono' => 'fab fa-firstdraft',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Venta de libros, revistas...',
            'codigo' => 'LB',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-book',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Empresas Acropolitanas',
            'codigo' => 'EA',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-industry',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Aporte Institutos',
            'codigo' => 'AI',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-balance-scale',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Aportes ordinarios o extraordinarios para las casa',
            'codigo' => 'AC',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-home',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Ingresos para el mantenimiento de la casa de campo',
            'codigo' => 'IS',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-home',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Ganancias por Inversiones',
            'codigo' => 'GI',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-chart-line',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Préstamos de terceros',
            'codigo' => 'PT',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-dollar-sign',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Otros Ingresos',
            'codigo' => 'OI',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-dollar-sign',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Organización actividades GEA/N.A.',
            'codigo' => 'AG',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-book',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Actividades Economia - Publicas',
            'codigo' => 'AECO',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-hand-holding-usd',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Vacaciones Divertidas',
            'codigo' => 'VCCNS',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-umbrella-beach',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Taller Oratoria',
            'codigo' => 'ORATORIA',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-microphone-alt',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Festival de Coros',
            'codigo' => 'COROS',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-music',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Alquiler Aula',
            'codigo' => 'AULA',
            'tipo' => 'ingreso',
            'icono' => 'fas fa-user-tie',
        ]);

        EconomiaCategoria::create([
            'nombre' => 'Alquiler',
            'codigo' => 'AQ',
            'tipo' => 'egreso',
            'icono' => 'fas fa-home',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Mensualidad Hipoteca',
            'codigo' => 'HP',
            'tipo' => 'egreso',
            'icono' => 'fas fa-calendar-day',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Servicios: agua, luz, teléfono...',
            'codigo' => 'SB',
            'tipo' => 'egreso',
            'icono' => 'fas fa-tint',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Seguros',
            'codigo' => 'SS',
            'tipo' => 'egreso',
            'icono' => 'fas fa-user-shield',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Mantenimiento de la sede',
            'codigo' => 'MS',
            'tipo' => 'egreso',
            'icono' => 'fas fa-hammer',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Compra de inmuebles',
            'codigo' => 'CI',
            'tipo' => 'egreso',
            'icono' => 'fas fa-money-bill-wave',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Compra de muebles varios',
            'codigo' => 'CM',
            'tipo' => 'egreso',
            'icono' => 'fas fa-couch',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Restauración o construcciones en la sede',
            'codigo' => 'RS',
            'tipo' => 'egreso',
            'icono' => 'fas fa-wrench',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Pago préstamos',
            'codigo' => '',
            'tipo' => 'egreso',
            'icono' => 'fas fa-landmark',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Ahorros',
            'codigo' => '',
            'tipo' => 'egreso',
            'icono' => 'fas fa-piggy-bank',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Inversión en empresas acropolitanas',
            'codigo' => '',
            'tipo' => 'egreso',
            'icono' => 'fas fa-dolly-flatbed',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Propaganda en Internet',
            'codigo' => 'PP',
            'tipo' => 'egreso',
            'icono' => 'fas fa-ad',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Alojamiento de página Web',
            'codigo' => '',
            'tipo' => 'egreso',
            'icono' => 'fas fa-internet-explorer',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Propaganda',
            'codigo' => 'PROPA',
            'tipo' => 'egreso',
            'icono' => 'fas fa-bullhorn',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Difusión de las actividades RR.PP.',
            'codigo' => 'RP',
            'tipo' => 'egreso',
            'icono' => 'fas fa-people-arrows',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Organización actividades RR.PP.',
            'codigo' => 'AR',
            'tipo' => 'egreso',
            'icono' => 'fas fa-people-arrows',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Organización actividades GEA/N.A.',
            'codigo' => 'AG',
            'tipo' => 'egreso',
            'icono' => 'fas fa-users',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Organización eventos',
            'codigo' => 'OEVEN',
            'tipo' => 'egreso',
            'icono' => 'fas fa-people-carry',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Secretarias y FF.VV.',
            'codigo' => 'FFVV',
            'tipo' => 'egreso',
            'icono' => 'fas fa-briefcase',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Subención a Institutos',
            'codigo' => 'SI',
            'tipo' => 'egreso',
            'icono' => 'fas fa-university',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Subención empresas acropolitanas',
            'codigo' => 'SE',
            'tipo' => 'egreso',
            'icono' => 'fas fa-industry',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Cursos externos/cursillos',
            'codigo' => 'CE',
            'tipo' => 'egreso',
            'icono' => 'fas fa-university',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Ediciones',
            'codigo' => 'ED',
            'tipo' => 'egreso',
            'icono' => 'fas fa-book',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Impuestos, Legales, Contabilidad - Oratoria',
            'codigo' => 'IMLEG',
            'tipo' => 'egreso',
            'icono' => 'fas fa-file-invoice-dollar',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Impuestos Filosofia ACTIVA - IT',
            'codigo' => 'IM',
            'tipo' => 'egreso',
            'icono' => 'fas fa-file-invoice',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Mantenimiento del D.N.',
            'codigo' => '',
            'tipo' => 'egreso',
            'icono' => 'fas fa-users',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Viajes del D.N.',
            'codigo' => 'VD',
            'tipo' => 'egreso',
            'icono' => 'fas fa-plane-departure',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Visitas Internacionales',
            'codigo' => '',
            'tipo' => 'egreso',
            'icono' => 'fas fa-globe-americas',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'C. Programas Internacionales',
            'codigo' => '',
            'tipo' => 'egreso',
            'icono' => 'fas fa-globe-americas',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'C. OINA',
            'codigo' => 'CUOTAOINA',
            'tipo' => 'egreso',
            'icono' => 'fas fa-globe',
        ]);
        EconomiaCategoria::create([
            'nombre' => 'Otros egresos',
            'codigo' => 'OE',
            'tipo' => 'egreso',
            'icono' => 'fas fa-coins',
        ]);
        $this->cargarMiembros();
        $this->cargarAportes(2019);
        $this->cargarAportes(2020);
        //$this->cargarDiario(__DIR__ . '/diario.tsv', true, false, 'caja');
        $this->cargarDiario(__DIR__ . '/diario.tsv', false, true, 'caja');
        //$this->cargarDiario(__DIR__ . '/cuenta.tsv', true, false, 'cuenta');
        $this->cargarDiario(__DIR__ . '/cuenta.tsv', false, true, 'cuenta');
    }

    private function cargarDiario($path, $log, $save, $libreta)
    {
        $file = file($path);
        $saldoCheck = 0;
        foreach ($file as $i => $fila) {
            list(
                $fecha, $detalle, $ingreso, $egreso, $saldo, $recibo, $cuenta,
                $nro,
                $detalle2,
                $coros,
                $miembro,
            ) = explode("\t", $fila);
            $fecha = trim($fecha);
            $ingreso = trim($ingreso);
            $egreso = trim($egreso);
            $saldo = trim($saldo);
            $miembro = trim($miembro);
            if ($fecha === '') {
                continue;
            }
            if ($ingreso === '' && $egreso === '') {
                continue;
            }
            if ($saldo === '') {
                continue;
            }
            $fecha = explode('/', $fecha);
            $gestion = $fecha[2];
            $fecha = sprintf("%4d-%02d-%02d", $fecha[2], $fecha[1], $fecha[0]);
            $ingreso = floatval(str_replace(['.',','], ['','.'], $ingreso));
            $egreso = floatval(str_replace(['.',','], ['','.'], $egreso));
            $saldo = floatval(str_replace(['.',','], ['','.'], $saldo));
            $cuenta = trim($cuenta);
            $saldoCheck += $ingreso - $egreso;
            if ($miembro) {
                $miembroO = Miembro::where('nombre', $miembro)->first();
                if (!$miembroO) {
                    dd("Miembro no encontrado: $miembro");
                }
                $miembro_id = $miembroO->id;
            } else {
                $miembro_id = null;
            }
            if ($log) {
                print("$i: $fecha, $detalle, $ingreso, $egreso, $saldo, $recibo, $cuenta\n");
                if (abs($saldo - $saldoCheck) > 0.001) {
                    dd('Saldo no coincide:', $saldo, $saldoCheck);
                }
            }
            if ($save) {
                Diario::create(compact('gestion', 'fecha', 'detalle', 'ingreso', 'egreso', 'saldo', 'recibo', 'cuenta', 'libreta', 'miembro_id'));
            }
        }
    }

    private function cargarMiembros()
    {
        $file = file(__DIR__ . '/miembros.tsv');
        $random = new RandomAvatar();
        $bar = $this->command->getOutput()->createProgressBar(count($file));
        $bar->start();
        foreach ($file as $fila) {
            list($nombre, $activo) = explode("\t", $fila);
            $nombre = trim($nombre);
            $avatar = null;
            $image = $random->generate('color');
            $imageName = 'avatar.png';
            $path = uniqid('up', true) . "/{$imageName}";
            Storage::drive('public')->put($path, $image);
            $avatar = [
                'url' => url("storage/{$path}"),
                'name' => $imageName,
                'mime' => 'image/png',
                'path' => $path,
            ];
            Miembro::create(compact('nombre', 'avatar', 'activo'));
            $bar->advance();
        }
        $bar->finish();
    }

    public function cargarAportes($gestion)
    {
        $file = file(__DIR__ . '/cuotas' . $gestion . '.tsv');
        foreach ($file as $fila) {
            list(
                $nombre, $pendiente, $acuenta, $rec,
                $ene, $eneRec,
                $feb, $febRec,
                $mar, $marRec,
                $abr, $abrRec,
                $may, $mayRec,
                $jun, $junRec,
                $jul, $julRec,
                $ago, $agoRec,
                $sep, $sepRec,
                $oct, $octRec,
                $nov, $novRec,
                $dic, $dicRec,
                $pendiente2,
                $mensual,
                $total,
            ) = explode("\t", substr($fila, 0, -1));
            $nombre = trim($nombre);
            $mensual = trim($mensual);
            $miembro = Miembro::where('nombre', $nombre)->first();
            if (!$miembro) {
                dd($nombre);
            }
            $this->cargarAporte(1, $gestion, $ene, $eneRec, $miembro);
            $this->cargarAporte(2, $gestion, $feb, $febRec, $miembro);
            $this->cargarAporte(3, $gestion, $mar, $marRec, $miembro);
            $this->cargarAporte(4, $gestion, $abr, $abrRec, $miembro);
            $this->cargarAporte(5, $gestion, $may, $mayRec, $miembro);
            $this->cargarAporte(6, $gestion, $jun, $junRec, $miembro);
            $this->cargarAporte(7, $gestion, $jul, $julRec, $miembro);
            $this->cargarAporte(8, $gestion, $ago, $agoRec, $miembro);
            $this->cargarAporte(9, $gestion, $sep, $sepRec, $miembro);
            $this->cargarAporte(10, $gestion, $oct, $octRec, $miembro);
            $this->cargarAporte(11, $gestion, $nov, $novRec, $miembro);
            $this->cargarAporte(12, $gestion, $dic, $dicRec, $miembro);
            if ($mensual) {
                $miembro->aporte_mensual = $mensual;
            }
            $miembro->save();
        }
    }

    private function cargarAporte($mes, $gestion, $monto, $rec, Miembro $miembro)
    {
        $monto = trim($monto);
        $rec = trim($rec);
        if ($monto) {
            Aporte::create([
                'miembro_id' => $miembro->id,
                'mes' => $mes,
                'gestion' => $gestion,
                'monto' => $monto,
            ]);
            $miembro->ultimo_aporte_mes = $mes;
            $miembro->ultimo_aporte_gestion = $gestion;
        }
    }
}
