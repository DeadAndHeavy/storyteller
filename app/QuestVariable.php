<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestVariable extends Model
{
    protected $fillable = ['quest_id', 'title', 'type', 'default_value', 'track_state'];

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }
}
