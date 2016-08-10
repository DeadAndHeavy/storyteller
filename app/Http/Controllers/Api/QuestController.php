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
        Quest::firstOrCreate($this->request->input('quest'));
        var_dump($quest);die;
    }
}
