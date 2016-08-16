<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScenarioStep extends Model
{
    protected $fillable = ['quest_id', 'episode_id'];

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }

    public function episode()
    {
        return $this->belongsTo('App\Episode', 'episode_id');
    }
}
