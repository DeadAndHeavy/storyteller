<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = ['title', 'content', 'type', 'quest_id'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function(Episode $episode) {
            $episode->content = clean($episode->content);
        });
    }

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }

    public function episodeActions()
    {
        return $this->hasMany('App\EpisodeAction');
    }
}
