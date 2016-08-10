<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = ['content', 'quest_id', 'episode_number'];

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }
}
