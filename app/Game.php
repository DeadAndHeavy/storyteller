<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['quest_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }
}
