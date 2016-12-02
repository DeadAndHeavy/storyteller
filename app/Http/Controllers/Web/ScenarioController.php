<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Core\Service\QuestLogicService;
use App\Core\Service\ScenarioService;
use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\MassVariablesRequest;
use App\Quest;
use App\QuestVariable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ScenarioController extends Controller
{
    private $questService;
    private $episodeService;
    /**
     * @var ScenarioService
     */
    private $scenarioService;
    /**
     * @var QuestLogicService
     */
    private $questLogicService;

    public function __construct(QuestService $questService, EpisodeService $episodeService, ScenarioService $scenarioService, QuestLogicService $questLogicService)
    {
        $this->questService = $questService;
        $this->episodeService = $episodeService;
        $this->scenarioService = $scenarioService;
        $this->questLogicService = $questLogicService;
    }

    public function index($questId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        return view('web/scenario/index', [
            'questId' => $questId,
            'episodes' => Episode::where('quest_id', $questId)->with('quest', 'episodeActions')->get(),
            'variableTypes' => QuestLogicService::getAllVariableTypes(),
            'questVariables' => $this->questLogicService->getQuestVariables($questId),
        ]);
    }

    public function save(Request $request)
    {
        $targets = $request->get('scenario_episode_action_targets');

        foreach ($targets as $episodeActionId => $targetEpisodeId) {
            if ($this->episodeService->isOwnEpisodeAction($episodeActionId) && $this->episodeService->isOwnEpisode($targetEpisodeId)) {
                $this->episodeService->setEpisodeActionTargetId($episodeActionId, $targetEpisodeId);
            }
        }

        return redirect(route('own_quests'));
    }

    public function renderNewScenarioStep(Request $request)
    {
        $targetEpisode = Episode::find($request->get('targetEpisodeId'));
        return view('web/scenario/partial/scenario_step', [
            'episode' => $targetEpisode,
            'imageModificationTime' => filemtime($this->episodeService->getEpisodeImagePath($targetEpisode->quest_id, $targetEpisode->id)),
        ])->render();
    }

    public function play($questId)
    {
        if (!$this->scenarioService->isValidQuest($questId)) {
            flash('This quest is not over', 'danger');
            return back();
        }
        $this->scenarioService->initiateGame($questId);

        $startEpisode = EpisodeService::getStartEpisode($questId);

        return view('web/scenario/play', [
            'quest' => Quest::find($questId),
            'imageModificationTime' => filemtime($this->episodeService->getEpisodeImagePath($questId, $startEpisode->id)),
            'startEpisode' => $startEpisode
        ]);
    }

    public function saveVariables(MassVariablesRequest $request)
    {
        if (!$this->questService->isOwnQuest($request->questId)) {
            throw new BadRequestHttpException();
        }

        $this->questLogicService->saveVariables($request->get('variables_list'));

        return redirect(route('scenario', ['questId' => $request->questId]));
    }

    public function renderVariableEditForm(Request $request)
    {
        return view('web/scenario/partial/rendered_edit_variable', [
            'variable' => QuestVariable::find($request->input('variable_id')),
            'variableTypes' => QuestLogicService::getAllVariableTypes(),
        ])->render();
    }

    public function destroyVariable($questId, $variableId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        $this->questLogicService->destroyVariable($variableId);

        return redirect(route('scenario', ['questId' => $questId]));
    }

    public function finish($questId)
    {
        $this->scenarioService->finishGame($questId);

        return redirect(route('public_quests'));
    }
}
