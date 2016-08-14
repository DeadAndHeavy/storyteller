<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = ['title', 'content', 'quest_id'];

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }

    public function episodeActions()
    {
        return $this->hasMany('App\EpisodeAction');
    }
}
