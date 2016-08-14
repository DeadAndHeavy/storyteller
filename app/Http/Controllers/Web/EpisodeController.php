<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\EpisodeRequest;
use App\Http\Requests\QuestRequest;
use App\Quest;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    private $questService;
    private $episodeService;

    public function __construct(QuestService $questService, EpisodeService $episodeService)
    {
        $this->questService = $questService;
        $this->episodeService = $episodeService;
    }

    public function index($questId)
    {
        $quest = Quest::find($questId);
        $episodes = Episode::where('quest_id', $questId)->with('episodeActions')->get();
        return view('web/episode/index', [
            'quest' => $quest,
            'episodes' => $episodes
        ]);
    }

    public function create($questId)
    {
        $quest = Quest::find($questId);
        $episodes = Episode::where('quest_id', $questId)->get();
        return view('web/episode/create', [
            'quest' => $quest,
            'episodes' => $episodes
        ]);
    }

    public function store(EpisodeRequest $request)
    {
        $this->episodeService->store($request->all());
        return redirect(route('all_episodes', $request->questId));
    }

    public function renderEpisodeAction(Request $request)
    {
        $episodes = Episode::where('quest_id', $request->get('questId'))->get();
        return view('web/episode/partial/episode_action', [
            'action_index' => $request->get('actionIndex'),
            'action_content' => '',
            'episodes' => $episodes
        ])->render();
    }
}
