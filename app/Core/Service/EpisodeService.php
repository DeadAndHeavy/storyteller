<?php

namespace App\Core\Service;

use App\Episode;
use App\EpisodeAction;
use Auth;
use File;
use Image;

/**
 * Service class for various operations with episodes
 */

class EpisodeService
{
    /**
     * Max length of episode content
     */
    const EPISODE_MAX_LENGTH = 10000;

    /**
     * Episode types
     */
    const EPISODE_TYPE_START = 'start';
    const EPISODE_TYPE_NORMAL = 'normal';
    const EPISODE_TYPE_FINISH = 'finish';

    /**
     * Get all episode types (start, normal, finish)
     *
     * @return array
     */
    public static function getAllEpisodeTypes()
    {
        return [
            self::EPISODE_TYPE_START => trans('episode.type_' . self::EPISODE_TYPE_START),
            self::EPISODE_TYPE_NORMAL => trans('episode.type_' . self::EPISODE_TYPE_NORMAL),
            self::EPISODE_TYPE_FINISH => trans('episode.type_' . self::EPISODE_TYPE_FINISH),
        ];
    }

    /**
     * Check, whether the episode is owned by the current user
     *
     * @param $episodeId
     * @return bool
     */
    public function isOwnEpisode($episodeId)
    {
        return Episode::find($episodeId)->quest->user_id == Auth::user()->id;
    }

    /**
     * Check, whether the episode action is owned by the current user
     *
     * @param int $episodeActionId
     * @return bool
     */
    public function isOwnEpisodeAction($episodeActionId)
    {
        return EpisodeAction::find($episodeActionId)->episode->quest->user_id == Auth::user()->id;
    }

    /**
     * Get all quest episodes
     *
     * @param int $questId
     * @return mixed
     */
    public function getQuestEpisodes($questId)
    {
        return Episode::where('quest_id', $questId)->with('quest', 'episodeActions')->get();
    }

    /**
     * Store new episode (episode model, episode image and episode actions)
     *
     * @param array $questData
     */
    public function store($questData)
    {
        /** @var Episode $episodeModel */
        $episodeModel = Episode::create($questData);

        $this->uploadEpisodeImage($questData['episode_image'], $episodeModel->quest_id, $episodeModel->id);

        foreach ($questData['actions_list'] as $actionData) {
            $data = [
                'episode_id' => $episodeModel->id,
                'content' => $actionData['content']
            ];
            EpisodeAction::create($data);
        }
    }

    /**
     * Update episode data
     *
     * @param int $episodeId
     * @param array $questData
     */
    public function update($episodeId, $questData)
    {
        Episode::find($episodeId)->update($questData);

        if (isset($questData['episode_image']) && $questData['episode_image']) {
            $this->uploadEpisodeImage($questData['episode_image'], $questData['quest_id'], $episodeId);
        }

        $currentEpisodeActionIds = [];
        $oldEpisodeActionIds = Episode::find($episodeId)->episodeActions->pluck('id')->toArray();

        foreach ($questData['actions_list'] as $episodeActionData) {
            if ($episodeActionData['action_id']) {
                EpisodeAction::find($episodeActionData['action_id'])->update(['content' => $episodeActionData['content']]);
                $currentEpisodeActionIds[] = $episodeActionData['action_id'];
            } else {
                EpisodeAction::create([
                    'content' => $episodeActionData['content'],
                    'episode_id' => $episodeId
                ]);
            }
        }
        EpisodeAction::destroy(array_diff($oldEpisodeActionIds, $currentEpisodeActionIds));
    }

    /**
     * Delete episode with image
     *
     * @param int $questId
     * @param int $episodeId
     */
    public function destroy($questId, $episodeId)
    {
        if (Episode::destroy($episodeId)) {
            $this->deleteEpisodeImage($questId, $episodeId);
        }
    }

    /**
     * Set episode action target id
     *
     * @param int $episodeActionId
     * @param int $targetEpisodeId
     */
    public function setEpisodeActionTargetId($episodeActionId, $targetEpisodeId)
    {
        EpisodeAction::find($episodeActionId)->update(['target_episode_id' => $targetEpisodeId]);
    }

    /**
     * Return start episode (only one start episode for quest)
     *
     * @param int $questId
     * @return mixed
     */
    public static function getStartEpisode($questId)
    {
        return Episode::where('quest_id', $questId)->where('type', self::EPISODE_TYPE_START)->first();
    }

    /**
     * Upload and fit episode image
     *
     * @param \Illuminate\Http\UploadedFile $uploadedTmpFile
     * @param int $questId
     * @param int $episodeId
     */
    public function uploadEpisodeImage(\Illuminate\Http\UploadedFile $uploadedTmpFile, $questId, $episodeId)
    {
        $questImagesDir = public_path('quests_images' . '/' . $questId);
        if (!File::exists($questImagesDir)) {
            File::makeDirectory($questImagesDir, 0777, true, true);
        }
        Image::make($uploadedTmpFile->getRealPath())->fit(350, 350)->save($questImagesDir . '/' . $episodeId . '.jpg');
    }

    /**
     * Return path to the episode image file
     *
     * @param int $questId
     * @param int $episodeId
     * @return string
     */
    public function getEpisodeImagePath($questId, $episodeId)
    {
        return public_path('quests_images' . '/' . $questId . '/' . $episodeId . '.jpg');
    }

    /**
     * Return path to the quest images folder
     *
     * @param int $questId
     * @return string
     */
    public function getQuestImagesFolderPath($questId)
    {
        return public_path('quests_images' . '/' . $questId);
    }

    /**
     * Delete episode image and quest images folder (if this folder is empty)
     *
     * @param int $questId
     * @param int $episodeId
     */
    public function deleteEpisodeImage($questId, $episodeId)
    {
        $episodeImagePath = $this->getEpisodeImagePath($questId, $episodeId);

        if (File::exists($episodeImagePath)) {
            File::delete($episodeImagePath);
        }
    }
}