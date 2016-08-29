<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\QuestApproveService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    private $questApproveService;

    public function __construct(QuestApproveService $questApproveService)
    {
        $this->questApproveService = $questApproveService;
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
