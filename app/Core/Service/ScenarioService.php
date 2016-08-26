<?php

namespace App\Core\Service;

use App\Quest;

class ScenarioService
{
    public function isValidQuest($questId)
    {
        $valid = true;
        $quest = Quest::find($questId);
        $episodes = $quest->episodes;

        /**
         * Checking step 1: Quest must contain the start and finish episodes
         */
        $hasStartEpisode = count($episodes->filter(function ($episode) {
                return $episode->type == EpisodeService::EPISODE_TYPE_START;
            })) > 0;
        $hasFinishEpisode = count($episodes->filter(function ($episode) {
                return $episode->type == EpisodeService::EPISODE_TYPE_FINISH;
            })) > 0;

        if (!$hasStartEpisode || !$hasFinishEpisode) {
            $valid = false;
        }

        /**
         * Checking step 2: All episode actions should refer to other episodes
         */
        if ($valid) {
            foreach ($episodes as $episode) {
                foreach ($episode->episodeActions as $episodeAction) {
                    if ($episode->type == EpisodeService::EPISODE_TYPE_FINISH) {
                        continue;
                    }
                    if (!$episodeAction->target_episode_id) {
                        $valid = false;
                        break;
                    }
                    if (!$valid) {
                        break;
                    }
                }
            }
        }

        return $valid;
    }
}