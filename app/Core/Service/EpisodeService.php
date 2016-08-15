<?php

namespace App\Core\Service;

use App\Episode;
use App\EpisodeAction;
use App\Quest;
use Illuminate\Support\Facades\Validator;

class EpisodeService
{
    public function getAll() {
        return Quest::all();
    }

    public function store($questData)
    {
        /** @var Episode $episodeModel */
        $episodeModel = Episode::create($questData);
        
        foreach ($questData['actions_list'] as $actionData) {
            $data = [
                'episode_id' => $episodeModel->id,
                'content' => $actionData['content']
            ];
            EpisodeAction::create($data);
        }
    }

    public function update($episodeId, $questData)
    {
        Episode::find($episodeId)->update($questData);

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

    public function destroy($id)
    {
        Episode::destroy($id);
    }

    /*public function addEpisode($episodeData)
    {
        Episode::create($episodeData);
    }*/
}