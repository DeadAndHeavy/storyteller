<?php

namespace App\Core\Service;

use App\Episode;
use Auth;
use App\Quest;

class QuestService
{
    const QUEST_GENRE_SIMULATOR = 'simulator';
    const QUEST_GENRE_RPG = 'rpg';
    const QUEST_GENRE_ADVENTURE = 'adventure';

    public static function getAllQuestGenres()
    {
        return [
            self::QUEST_GENRE_SIMULATOR => trans('quest.genre_' . self::QUEST_GENRE_SIMULATOR),
            self::QUEST_GENRE_RPG => trans('quest.genre_' . self::QUEST_GENRE_RPG),
            self::QUEST_GENRE_ADVENTURE => trans('quest.genre_' . self::QUEST_GENRE_ADVENTURE),
        ];
    }

    public function isOwnQuest($questId)
    {
        return Quest::find($questId)->user_id == Auth::user()->id;
    }

    public function getAll() {
        return Quest::all();
    }

    public function getApproved() {
        return Quest::whereHas('approval', function ($query) {
            $query->where('approve_status', QuestApproveService::QUEST_APPROVE_STATUS_APPROVED);
        })->get();
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
}