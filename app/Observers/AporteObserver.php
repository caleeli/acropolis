<?php

namespace App\Observers;

use App\Aporte;

class AporteObserver
{
    /**
     * Handle the aporte "saved" event.
     *
     * @param  \App\Aporte  $aporte
     * @return void
     */
    public function saved(Aporte $aporte)
    {
        $last = Aporte::orderBy('gestion', 'desc')
        ->orderBy('mes', 'desc')
        ->where('miembro_id', $aporte->miembro_id)
        ->first();
        $aporte->miembro->ultimo_aporte_mes = $last->mes;
        $aporte->miembro->ultimo_aporte_gestion = $last->gestion;
        $aporte->miembro->save();
    }
}
