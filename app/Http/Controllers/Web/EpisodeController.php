<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\EpisodeRequest;
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
        $episodes = Episode::where('quest_id', $questId)->with('quest', 'episodeActions')->get();
        return view('web/episode/index', [
            'questId' => $questId,
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
        $questId = $request->get('questId');
        $episodes = Episode::where('quest_id', $questId)->get();
        return view('web/episode/partial/episode_action', [
            'action_index' => $request->get('actionIndex'),
            'action_content' => '',
            'episodes' => $episodes,
            'quest_id' => $questId
        ])->render();
    }

    public function edit($questId, $episodeId)
    {
        return view('web/episode/edit', [
            'questId' => $questId,
            'episode' => Episode::find($episodeId),
        ]);
    }

    public function update(EpisodeRequest $request)
    {
        $this->episodeService->update($request->episodeId, $request->all());
        return redirect(route('all_episodes', ['questId' => $request->questId]));
    }

    public function destroy($questId, $episodeId)
    {
        $this->episodeService->destroy($episodeId);
        return redirect(route('all_episodes', ['questId' => $questId]));
    }
}
