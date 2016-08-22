<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use Illuminate\Http\Request;

class ScenarioController extends Controller
{
    private $questService;
    private $episodeService;

    public function __construct(QuestService $questService, EpisodeService $episodeService)
    {
        $this->questService = $questService;
        $this->episodeService = $episodeService;
    }

    public function index($questId)
    {
        $episodes = Episode::where('quest_id', $questId)->with('quest', 'episodeActions')->get();
        return view('web/scenario/index', [
            'questId' => $questId,
            'episodes' => $episodes
        ]);
    }

    public function save(Request $request)
    {
        var_dump($request->all());die;
        $this->episodeService->store($request->all());
        return redirect(route('all_episodes', $request->questId));
    }

    public function renderNewStep(Request $request)
    {
        $questId = $request->get('questId');
        $currentEpisodeId = $request->get('currentEpisodeId');
        $episodes = Episode::where('quest_id', $questId)->with('quest', 'episodeActions')->get();
        return view('web/scenario/partial/scenario_step', [
            'questId' => $questId,
            'episodes' => $episodes,
            'currentEpisode' => $currentEpisodeId ? Episode::find($currentEpisodeId) : null,
        ])->render();
    }
}
