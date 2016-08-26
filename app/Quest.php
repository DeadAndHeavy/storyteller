<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = ['name', 'description', 'genre', 'user_id', 'approved'];

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
}
