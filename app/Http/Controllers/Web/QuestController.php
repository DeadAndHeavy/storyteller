<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\QuestRequest;
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
        return view('web/quest/ownQuests', [
            'quests' => $ownQuests
        ]);
    }

    public function addEpisodeHtml(Request $request)
    {
        return view('web/quest/partial/add_episode', [
            'episode_number' => $request->input('episode_number')
        ]);
    }

    public function create()
    {
        return view('web/quest/create');
    }

    public function store(QuestRequest $request)
    {
        $this->questService->store($request->all());
        return redirect('/quest/own');
    }
}
