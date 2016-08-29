<?php

namespace App\Http\Controllers\Web;

use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\EpisodeRequest;
use App\Http\Requests\QuestRequest;
use App\Quest;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    private $questService;

    public function __construct(QuestService $questService)
    {
        $this->questService = $questService;
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
        return view('web/quest/edit', [
            'quest' => Quest::find($questId),
            'genres' => $this->questService->getAllQuestGenres(),
        ]);
    }

    public function update(QuestRequest $request)
    {
        $this->questService->update($request->questId, $request->all());
        return redirect('/quest/own');
    }

    public function destroy($questId)
    {
        $this->questService->destroy($questId);
        return redirect('/quest/own');
    }
}
