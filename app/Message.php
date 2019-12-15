<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $attributes = [
        'user_id' => null,
        'category_id' => null,
        'title' => 'Título del mensaje',
        'content' => '<div>Contenido del mensaje</div>',
    ];

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
