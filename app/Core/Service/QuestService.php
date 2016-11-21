<?php

namespace App\Core\Service;

use App\Episode;
use App\QuestComment;
use Auth;
use App\Quest;
use File;
use Image;

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

    public function isOwnQuestComment($commentId)
    {
        return QuestComment::find($commentId)->user_id == Auth::user()->id;
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
        $questModel = Quest::create($questData);
        $this->uploadQuestImage($questData['quest_image'], $questModel->id);
    }

    public function update($questId, $questData)
    {
        Quest::find($questId)->update($questData);

        if (isset($questData['quest_image']) && $questData['quest_image']) {
            $this->uploadQuestImage($questData['quest_image'], $questId);
        }
    }

    public function destroy($questId)
    {
        if (Quest::destroy($questId)) {
            $this->deleteQuestImages($questId);
        }
    }

    public function addEpisode($episodeData)
    {
        Episode::create($episodeData);
    }

    public function deleteQuestImages($questId)
    {
        $questImagesPath = public_path('quests_images' . '/' . $questId);

        if (File::exists($questImagesPath)) {
            File::deleteDirectory($questImagesPath);
        }
    }

    /**
     * Upload and fit quest image
     *
     * @param \Illuminate\Http\UploadedFile $uploadedTmpFile
     * @param int $questId
     */
    public function uploadQuestImage(\Illuminate\Http\UploadedFile $uploadedTmpFile, $questId)
    {
        $questImagesDir = public_path('quests_images' . '/' . $questId);
        if (!File::exists($questImagesDir)) {
            File::makeDirectory($questImagesDir, 0777, true, true);
        }
        Image::make($uploadedTmpFile->getRealPath())->fit(350, 350)->save($questImagesDir . '/quest_logo.jpg');
    }

    public function getQuestLogoImagePath($questId)
    {
        return public_path('quests_images' . '/' . $questId . '/quest_logo.jpg');
    }
}