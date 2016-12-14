<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpisodeAction extends Model
{
    protected $fillable = ['content', 'target_episode_id', 'episode_id', 'logic'];

    public function episode()
    {
        return $this->belongsTo('App\Episode', 'episode_id');
    }
}
