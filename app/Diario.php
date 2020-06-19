<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
    public function scopeWhereGestionActual($query)
    {
        return $query->where('gestion', date('Y'));
    }
}
