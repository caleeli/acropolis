<?php

namespace App\Observers;

use App\Diario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiarioObserver
{
    /**
     * Handle the Diario "creating" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function creating(Diario $diario)
    {
        $diario->saldo = Diario::where('libreta', $diario->libreta)
            ->sum(DB::raw('ingreso-egreso'))
            + $diario->ingreso - $diario->egreso;
    }

    /**
     * Handle the Diario "saving" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function saving(Diario $diario)
    {
        if (!$diario->fecha) {
            $diario->fecha = Carbon::now();
        }
        $diario->gestion = $diario->fecha->format('Y');
    }

    /**
     * Handle the Diario "updating" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function updating(Diario $diario)
    {
        $diario->actualizaSaldo();
        foreach (Diario::where('id', '>', $diario->id)->get() as $next) {
            $next->save();
        }
    }

    /**
     * Handle the Diario "updated" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function updated(Diario $diario)
    {
        foreach (Diario::where('id', '>', $diario->id)->get() as $next) {
            $next->actualizaSaldo();
            $next->save();
        }
    }

    /**
     * Handle the Diario "created" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function created(Diario $diario)
    {
        /*if ($diario->miembro_id && $diario->cuenta === 'CT') {
            $diario->aporte()->create([
                'miembro_id' => $diario->miembro_id,
            ]);
        }*/
    }

    /**
     * Handle the Diario "deleted" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function deleted(Diario $diario)
    {
        foreach (Diario::where('id', '>', $diario->id)->get() as $next) {
            $next->actualizaSaldo();
            $next->save();
        }
    }

    /**
     * Handle the Diario "restored" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function restored(Diario $diario)
    {
        //
    }

    /**
     * Handle the Diario "force deleted" event.
     *
     * @param  \App\Diario  $diario
     * @return void
     */
    public function forceDeleted(Diario $diario)
    {
        //
    }
}
