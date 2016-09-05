<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\QuestCommentService;
use App\Core\Service\VoteService;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\QuestCommentRequest;
use App\Http\Requests\QuestRequest;
use App\Quest;
use App\QuestComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestController extends Controller
{
    private $questService;
    /**
     * @var VoteService
     */
    private $voteService;
    /**
     * @var QuestCommentService
     */
    private $questCommentService;

    public function __construct(QuestService $questService, VoteService $voteService, QuestCommentService $questCommentService)
    {
        $this->questService = $questService;
        $this->voteService = $voteService;
        $this->questCommentService = $questCommentService;
    }

    public function index()
    {
        $quests = $this->questService->getApproved();

        return view('web/quest/index', [
            'quests' => $quests
        ]);
    }

    public function show($questId)
    {
        $quest = Quest::find($questId);

        if (!$quest) {
            throw new NotFoundHttpException();
        }

        return view('web/quest/show', [
            'quest' => $quest,
        ]);
    }

    public function ownQuests()
    {
        $ownQuests = $this->questService->getOwn();

        return view('web/quest/own_quests', [
            'quests' => $ownQuests
        ]);
    }

    public function create()
    {
        return view('web/quest/create', [
            'genres' => $this->questService->getAllQuestGenres()
        ]);
    }

    public function store(QuestRequest $request)
    {
        $this->questService->store($request->all());

        return redirect('/quest/own');
    }

    public function edit($questId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        return view('web/quest/edit', [
            'quest' => Quest::find($questId),
            'genres' => $this->questService->getAllQuestGenres(),
        ]);
    }

    public function update(QuestRequest $request)
    {
        if (!$this->questService->isOwnQuest($request->questId)) {
            throw new BadRequestHttpException();
        }

        $this->questService->update($request->questId, $request->all());

        return redirect('/quest/own');
    }

    public function destroy($questId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        $this->questService->destroy($questId);

        return redirect('/quest/own');
    }

    public function like($questId)
    {
        $this->voteService->store($questId, Auth::user()->id, VoteService::VOTE_TYPE_LIKE);

        return Quest::find($questId)->votes->pluck('type')->sum();
    }

    public function dislike($questId)
    {
        $this->voteService->store($questId, Auth::user()->id, VoteService::VOTE_TYPE_DISLIKE);

        return Quest::find($questId)->votes->pluck('type')->sum();
    }

    public function addComment(QuestCommentRequest $request)
    {
        $this->questCommentService->store($request->all());
    }

    public function updateComment(QuestCommentRequest $request)
    {
        if (!$this->questService->isOwnQuestComment($request->commentId)) {
            throw new BadRequestHttpException();
        }

        $this->questCommentService->update($request->commentId, $request->input('comment'));

        return redirect(route('quest_page' , ['questId' => $request->questId]));
    }

    public function renderQuestCommentForm(Request $request)
    {
        return view('web/quest/partial/quest_comment_form', [
            'comment' => QuestComment::find($request->input('comment_id'))
        ])->render();
    }

    public function renderQuestComment(Request $request)
    {
        return view('web/quest/partial/quest_comment', [
            'comment' => QuestComment::find($request->input('comment_id'))
        ])->render();
    }
}
