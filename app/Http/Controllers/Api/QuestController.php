<?php

namespace App\Http\Controllers\Api;

use App\Quest;

class QuestController extends BaseApiController
{
    public function index()
    {
        $quests = Quest::all();
        return $this->formattedResponse($quests);
    }

    public function store()
    {
        $quest = Quest::firstOrCreate($this->request->all());
        var_dump($quest);die;
    }
}
