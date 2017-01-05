<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Core\Service\QuestLogicService;
use App\Core\Service\ScenarioService;
use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\MassVariablesRequest;
use App\Http\Requests\QuestVariableRequest;
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

        $quest = Quest::find($questId);

        $episodes = Episode::where('quest_id', $questId)->with('episodeActions')->get();

        $episodeActionsValidationList = [];
        foreach ($episodes as $episode) {
            foreach ($episode->episodeActions as $episodeAction) {
                $episodeActionsValidationList[$episodeAction->id] = ($episode->type == EpisodeService::EPISODE_TYPE_FINISH) || ($this->scenarioService->isValidContainerLogic($episodeAction->id) && $episodeAction->target_episode_id);
            }
        }

        $episodeActionsValidationList['init'] = $this->scenarioService->isValidContainerLogic(false, $quest->id);

        return view('web/scenario/index', [
            'questId' => $questId,
            'quest' => $quest,
            'episodes' => $episodes,
            'episodeActionsValidationList' => $episodeActionsValidationList,
            'variableTypes' => QuestLogicService::getAllVariableTypes(),
            'questVariables' => $this->questLogicService->getQuestVariables($questId),
        ]);
    }

    public function saveLogic(Request $request)
    {
        $episodeActions = $request->get('episode_action');

        $this->questService->update($request->questId, ['init_logic' => $request->get('init_logic')]);

        if ($episodeActions && is_array($episodeActions)) {
            foreach ($episodeActions as $episodeActionId => $episodeActionData) {
                if ($this->episodeService->isOwnEpisodeAction($episodeActionId)) {
                    $this->episodeService->updateEpisodeAction($episodeActionId, $episodeActionData);
                }
            }
        }

        return redirect(route('scenario', ['questId' => $request->questId]));
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

    public function editVariable($questId, $variableId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        return view('web/scenario/edit_variable', [
            'questId' => $questId,
            'variable' => QuestVariable::find($variableId),
            'types' => QuestLogicService::getAllVariableTypes(),
        ]);
    }

    public function updateVariable(QuestVariableRequest $request)
    {
        if (!$this->questService->isOwnQuest($request->questId)) {
            throw new BadRequestHttpException();
        }

        $this->questLogicService->updateVariable($request->variableId, $request->all());

        return redirect(route('scenario', ['questId' => $request->questId]));
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
