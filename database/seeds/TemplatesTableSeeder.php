<?php

use App\Template;
use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::create([
            'icon' => 'fas fa-calendar-day',
            'category_id' => 1,
            'title' => 'Recordatorio Aporte Mensual',
            'content' => 'Ya empieza {{$mes}}<br/>Último aporte: {{$ultimo_aporte}}<br><a href="#/aporte/registrar">Registrar aporte</a><br><a href="#/aportes/ver">Ver mis aportes</a>',
            'link' => '/mensaje/ver/{{$mensaje->id}}',
        ]);
    }
}
