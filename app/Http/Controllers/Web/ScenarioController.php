<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Core\Service\ScenarioService;
use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Quest;
use Illuminate\Http\Request;

class ScenarioController extends Controller
{
    private $questService;
    private $episodeService;
    /**
     * @var ScenarioService
     */
    private $scenarioService;

    public function __construct(QuestService $questService, EpisodeService $episodeService, ScenarioService $scenarioService)
    {
        $this->questService = $questService;
        $this->episodeService = $episodeService;
        $this->scenarioService = $scenarioService;
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
        $targets = $request->get('scenario_episode_action_targets');

        foreach ($targets as $episodeActionId => $targetEpisodeId) {
            $this->episodeService->setEpisodeActionTargetId($episodeActionId, $targetEpisodeId);
        }

        return redirect(route('own_quests'));
    }

    public function renderNewScenarioStep(Request $request)
    {
        $targetEpisode = Episode::find($request->get('targetEpisodeId'));
        return view('web/scenario/partial/scenario_step', [
            'episode' => $targetEpisode
        ])->render();
    }

    public function play($questId)
    {
        if (!$this->scenarioService->isValidQuest($questId)) {
            flash('This quest is not over', 'danger');
            return back();
        }
        return view('web/scenario/play', [
            'quest' => Quest::find($questId),
            'startEpisode' => EpisodeService::getStartEpisode($questId)
        ]);
    }
}
