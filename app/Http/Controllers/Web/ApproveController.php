<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\QuestApproveService;
use App\Core\Service\ScenarioService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    private $questApproveService;
    /**
     * @var ScenarioService
     */
    private $scenarioService;

    public function __construct(QuestApproveService $questApproveService, ScenarioService $scenarioService)
    {
        $this->questApproveService = $questApproveService;
        $this->scenarioService = $scenarioService;
    }

    public function index()
    {
        $questsForApproving = $this->questApproveService->getNotApproved();

        return view('web/quest_approve/index', [
            'questsForApproving' => $questsForApproving
        ]);
    }

    public function submitForApproving($questId)
    {
        $this->questApproveService->sendForApprove($questId);

        return back();
    }

    public function approve($questId)
    {
        if (!$this->scenarioService->isValidQuest($questId)) {
            flash('Can\'t approve! Quest is not over', 'danger');
            return back();
        }

        $this->questApproveService->approve($questId);

        return back();
    }

    public function reject(Request $request)
    {
        $rejectData = [
            'message' => $request->input('message'),
            'approve_status' => QuestApproveService::QUEST_APPROVE_STATUS_REJECTED
        ];
        $this->questApproveService->reject($request->questId, $rejectData);

        return back();
    }
}
