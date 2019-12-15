<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $attributes = [
        'name' => 'Nombre de la categoria',
        'icon' => 'fas fa-atom',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
