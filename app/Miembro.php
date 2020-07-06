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

    public function aportes()
    {
        return $this->hasMany(Aporte::class);
    }
}
