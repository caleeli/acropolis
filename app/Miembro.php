<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JDD\Api\Traits\AjaxFilterTrait;

class Miembro extends Model
{
    use AjaxFilterTrait;

    protected $casts = [
        'activo' => 'boolean',
        'avatar' => 'array',
    ];

    protected $guarded = [];

    public function aportes()
    {
        return $this->hasMany(Aporte::class);
    }

    public static function totales()
    {
        return [
            'totalAporte' => Aporte::where('gestion', date('Y'))->sum('monto'),
            'totalPendiente' => Miembro::where('activo', true)->sum('saldo_pendiente'),
        ];
    }
}
