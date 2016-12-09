<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Core\Service\QuestLogicService;
use App\Core\Service\QuestService;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestVariableRequest;
use App\QuestVariable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class QuestLogicController extends Controller
{
    /**
     * @var QuestLogicService
     */
    private $questLogicService;
    /**
     * @var EpisodeService
     */
    private $episodeService;
    /**
     * @var QuestService
     */
    private $questService;

    public function __construct(QuestLogicService $questLogicService, QuestService $questService, EpisodeService $episodeService)
    {
        $this->questLogicService = $questLogicService;
        $this->episodeService = $episodeService;
        $this->questService = $questService;
    }

    public function index($questId)
    {
        $episodes = $this->episodeService->getQuestEpisodes($questId);
        $questVariables = $this->questLogicService->getQuestVariables($questId);

        return view('web/quest_logic/index', [
            'questId' => $questId,
            'episodes' => $episodes,
            'questVariables' => $questVariables
        ]);
    }

    public function createQuestVariable($questId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        return view('web/quest_logic/create_variable', [
            'questId' => $questId,
            'types' => QuestLogicService::getAllVariableTypes(),
        ]);
    }

    public function storeQuestVariable(QuestVariableRequest $request)
    {
        if (!$this->questService->isOwnQuest($request->questId)) {
            throw new BadRequestHttpException();
        }

        $this->questLogicService->storeVariable($request->all());

        return redirect(route('quest_logic_index', $request->questId));
    }


    public function renderVariable(Request $request)
    {
        return view('web/scenario/partial/rendered_variable', [
            'variableTypes' => QuestLogicService::getAllVariableTypes(),
            'variable_index' => $request->get('variableIndex'),
            'questId' => $request->get('questId'),
        ])->render();
    }
}
