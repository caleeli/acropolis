<?php

use App\Aporte;
use App\AvatarGenerator\RandomAvatar;
use App\Diario;
use App\EconomiaCategoria;
use App\Miembro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
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
        $this->cargarCategorias(__DIR__ . '/categorias.tsv');
        $this->cargarMiembros();
        // $this->cargarAportes(2019);
        // $this->cargarAportes(2020);
        //$this->cargarDiario(__DIR__ . '/diario.tsv', true, false, 'caja');
        $this->cargarDiario(__DIR__ . '/diario2022.tsv', true, true, 'caja');
        //$this->cargarDiario(__DIR__ . '/cuenta.tsv', true, false, 'cuenta');
        //$this->cargarDiario(__DIR__ . '/cuenta.tsv', false, true, 'cuenta');
    }

    private function cargarCategorias($path)
    {
        $file = file($path);
        foreach ($file as $i => $fila) {
            list($nombre, $codigo, $icono) = explode("\t", $fila);
            $nombre = trim($nombre);
            $codigo = trim($codigo);
            $icono = trim($icono);
            EconomiaCategoria::create([
                'nombre' => $nombre,
                'codigo' => $codigo,
                'icono' => $icono,
            ]);
        }
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
            if ($log) {
                print("\n$i: $fecha, $detalle, $ingreso, $egreso, $saldo, $recibo, $cuenta");
            }
            if ($fecha === '') {
                continue;
            }
            if ($ingreso === '' && $egreso === '') {
                continue;
            }
            if ($saldo === '') {
                // continue;
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
                if (abs($saldo - $saldoCheck) > 0.001) {
                    print("\n");
                    dump('Saldo no coincide:', $saldo, $saldoCheck);
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
        $urls = $random->many(count($file));
        $bar = $this->command->getOutput()->createProgressBar(count($file));
        $bar->start();
        foreach ($file as $i => $fila) {
            list($nombre, $cumple, $telefono) = explode("\t", $fila);
            $activo = '1';
            $nombre = trim($nombre);
            $cumple = trim($cumple);
            $telefono = trim($telefono);
            $avatar = null;
            $image = $random->getCachedByUrl($urls[$i]);
            $imageName = 'avatar.png';
            $path = uniqid('up', true) . "/{$imageName}";
            Storage::drive('public')->put($path, $image);
            $avatar = [
                'url' => url("storage/{$path}"),
                'name' => $imageName,
                'mime' => 'image/png',
                'path' => $path,
            ];
            Miembro::create(compact('nombre', 'avatar', 'activo', 'cumple', 'telefono'));
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
            if ($pendiente2) {
                $miembro->saldo_pendiente = $pendiente2;
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
