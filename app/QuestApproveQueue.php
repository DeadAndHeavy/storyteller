<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestApproveQueue extends Model
{
    protected $table = 'quest_approve_queue';

    protected $fillable = ['quest_id', 'approve_status', 'message'];

    public function quest()
    {
        return $this->belongsTo('App\Quest', 'quest_id');
    }
}
