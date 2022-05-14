<?php

namespace App;

use App\Traits\HasBladeCompile;
use App\Traits\HasMenus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasMenus;
    use Notifiable;
    use HasBladeCompile;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'avatar' => 'array',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function aportes()
    {
        return $this->hasMany(Aporte::class, 'miembro_id');
    }

    public function sendMessage($icon, $category_id, $title, $content, $link)
    {
        DB::beginTransaction();

        $properties = compact('icon', 'category_id', 'title', 'content');
        foreach (User::all() as $user) {
            $message = $user->messages()->create($properties);
            $message->title = $this->bladeMessage($title, $message);
            $message->content = $this->bladeMessage($content, $message);
            $message->link = $this->bladeMessage($link, $message);
            $message->save();
        }
        DB::commit();

        return true;
    }

    private function bladeMessage($content, Message $message)
    {
        return $this->bladeCompile($content, [
            'mensaje' => $message,
            'nombre' => $message->user->name,
            'mes' => __(date('F')),
            'ultimo_aporte' => $message->user->ultimo_aporte,
        ]);
    }

    public function totales()
    {
        $caja = Diario::whereCaja()->orderBy('id', 'desc')->limit(1)->first();
        $cuenta = Diario::whereCuenta()->orderBy('id', 'desc')->limit(1)->first();
        $ingresos = doubleval(Diario::noInicial()->whereGestionActual()->sum('ingreso'));
        $egresos = doubleval(Diario::noInicial()->whereGestionActual()->sum('egreso'));
        $saldoCaja = doubleval($caja->saldo);
        $saldoCuenta = doubleval($cuenta->saldo ?? 0);
        return compact('ingresos', 'egresos', 'saldoCaja', 'saldoCuenta');
    }
}
