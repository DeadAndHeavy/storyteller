<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['quest_id', 'user_id', 'type'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }
}
