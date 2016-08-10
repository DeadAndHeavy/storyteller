<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function episodes()
    {
        return $this->hasMany('App\Episode');
    }
}
