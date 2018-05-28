<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    public function likes() {
        return $this->hasMany('App\Like', 'post_id');//No es requerido 'post_id' ya que es el default de Laravel.
    }

    public function tags() {
        return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id')->withTimestamps();//Name of the pivot table is not required
    }
    //Mutator: Modifies data before saving it to the database.
    public function setTitleAttribute($value) {
        $this->attributes['title'] = strtolower($value);
    }
    //Accessor: Modifies data after it is retrived from the database.
    public function getTitleAttribute($value) {
        return strtoupper($value);
    }
}