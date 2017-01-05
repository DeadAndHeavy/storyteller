<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = ['name', 'description', 'genre', 'user_id', 'init_logic', 'approved'];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function episodes()
    {
        return $this->hasMany('App\Episode');
    }

    public function approval()
    {
        return $this->hasOne('App\QuestApproveQueue');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function comments()
    {
        return $this->hasMany('App\QuestComment');
    }

    public function games()
    {
        return $this->hasMany('App\Game');
    }
}
