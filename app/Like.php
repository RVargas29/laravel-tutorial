<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function post() {
        return $this->belongsTo('App\Post', 'post_id');//No es requerido 'post_id' ya que es el default de Laravel.
    }
}
