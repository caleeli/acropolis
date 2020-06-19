<?php

use App\EconomiaCategoria;
use Illuminate\Database\Seeder;

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
            'nombre' => 'Cuota mensual de miembros cobrada',
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
            'nombre' => 'Venta de libros, revistas, manuales',
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
    }
}
