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
        
        foreach ($questData['action_content_list'] as $action_content) {
            $data = [
                'episode_id' => $episodeModel->id,
                'content' => $action_content
            ];
            EpisodeAction::create($data);
        }
    }

    /*public function update($id, $questData)
    {
        Quest::find($id)->update($questData);
    }

    public function destroy($id)
    {
        Quest::find($id)->delete();
    }

    public function addEpisode($episodeData)
    {
        Episode::create($episodeData);
    }*/
}