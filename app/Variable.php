<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $fillable = ['quest_id', 'game_id', 'title', 'value'];
}
