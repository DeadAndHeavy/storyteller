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
        $quests = $this->questService->getAll();
        return view('web/quest/index', [
            'quests' => $quests
        ]);
    }

    public function ownQuests()
    {
        $ownQuests = $this->questService->getOwn();
        return view('web/quest/own_quests', [
            'quests' => $ownQuests
        ]);
    }

    public function addEpisode(EpisodeRequest $request)
    {
        $this->questService->addEpisode($request->all());

        return view('web/quest/partial/add_episode', [
            'episode_number' => $request->input('episode_number')
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

    public function edit($id)
    {
        return view('web/quest/edit', [
            'quest' => Quest::find($id),
            'genres' => $this->questService->getAllQuestGenres(),
        ]);
    }

    public function update(QuestRequest $request)
    {
        $this->questService->update($request->id, $request->all());
        return redirect('/quest/own');
    }

    public function destroy($id)
    {
        $this->questService->destroy($id);
        return redirect('/quest/own');
    }
}
