<?php

namespace App\Http\Controllers\Web;

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

    public function __construct(QuestService $questService)
    {
        $this->questService = $questService;
    }

    public function index($questId)
    {
        $quest = Quest::find($questId);
        $episodes = Episode::where('quest_id', $questId)->get();
        return view('web/episode/index', [
            'quest' => $quest,
            'episodes' => $episodes
        ]);
    }

    public function create($questId)
    {
        $quest = Quest::find($questId);
        return view('web/episode/create', [
            'quest' => $quest
        ]);
    }

    public function addEpisode(Request $request)
    {
        //$this->questService->addEpisode($request->all());
        $episode = new Episode;
        $episode->episode_number = $request->input('episode_number');

        return view('web/episode/partial/episode', [
            'episode' => $episode,
        ]);
    }
}
