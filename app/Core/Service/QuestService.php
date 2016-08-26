<?php

namespace App\Core\Service;

use App\Episode;
use App\QuestApproveQueue;
use Auth;
use App\Quest;
use Illuminate\Support\Facades\Validator;

class QuestService
{
    const QUEST_GENRE_SIMULATOR = 'simulator';
    const QUEST_GENRE_RPG = 'rpg';
    const QUEST_GENRE_ADVENTURE = 'adventure';

    const QUEST_APPROVE_STATUS_NOT_APPROVED = 0;
    const QUEST_APPROVE_STATUS_REJECTED = 1;
    const QUEST_APPROVE_STATUS_APPROVED = 2;

    public static function getAllQuestGenres()
    {
        return [
            self::QUEST_APPROVE_STATUS_NOT_APPROVED => trans('quest.approve_status_' . self::QUEST_GENRE_SIMULATOR),
            self::QUEST_APPROVE_STATUS_REJECTED => trans('quest.approve_status_' . self::QUEST_APPROVE_STATUS_REJECTED),
            self::QUEST_APPROVE_STATUS_APPROVED => trans('quest.approve_status_' . self::QUEST_APPROVE_STATUS_APPROVED),
        ];
    }

    public static function getApproveStatusList()
    {
        return [
            self::QUEST_GENRE_SIMULATOR => trans('quest.genre_' . self::QUEST_GENRE_SIMULATOR),
            self::QUEST_GENRE_RPG => trans('quest.genre_' . self::QUEST_GENRE_RPG),
            self::QUEST_GENRE_ADVENTURE => trans('quest.genre_' . self::QUEST_GENRE_ADVENTURE),
        ];
    }

    public static function getApproveStatusByKey($key)
    {

    }

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

    public function update($id, $questData)
    {
        Quest::find($id)->update($questData);
    }

    public function destroy($id)
    {
        Quest::destroy($id);
    }

    public function addEpisode($episodeData)
    {
        Episode::create($episodeData);
    }

    public function sendForApprove($questId)
    {
        QuestApproveQueue::create(['quest_id' => $questId]);
    }
}