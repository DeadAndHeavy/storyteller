<?php

namespace App\Core\Service;

use Auth;
use App\Quest;

class QuestService
{
    public function getAll() {
        return Quest::all();
    }

    public function getOwn() {
        return Quest::where('user_id', Auth::user()->id)->get();
    }

    public function store($questData)
    {
        Quest::create($questData);
    }
}