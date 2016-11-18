<?php

namespace App\Http\Controllers\Web;

use App\Core\Service\EpisodeService;
use App\Episode;
use App\Http\Controllers\Controller;
use App\Core\Service\QuestService;
use App\Http\Requests\EpisodeRequest;
use App\Quest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        $episodes = $this->episodeService->getQuestEpisodes($questId);

        return view('web/episode/index', [
            'questId' => $questId,
            'episodes' => $episodes
        ]);
    }

    public function create($questId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        return view('web/episode/create', [
            'quest' => Quest::find($questId),
            'episodes' => Episode::where('quest_id', $questId)->get(),
            'types' => $this->episodeService->getAllEpisodeTypes(),
        ]);
    }

    public function store(EpisodeRequest $request)
    {
        if (!$this->questService->isOwnQuest($request->questId)) {
            throw new BadRequestHttpException();
        }

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
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        return view('web/episode/edit', [
            'questId' => $questId,
            'episode' => Episode::find($episodeId),
            'imageModificationTime' => filemtime($this->episodeService->getEpisodeImagePath($questId, $episodeId)),
            'types' => $this->episodeService->getAllEpisodeTypes(),
        ]);
    }

    public function update(EpisodeRequest $request)
    {
        if (!$this->questService->isOwnQuest($request->questId)) {
            throw new BadRequestHttpException();
        }

        $this->episodeService->update($request->episodeId, $request->all());

        return redirect(route('edit_episode', ['questId' => $request->questId, 'episodeId' => $request->episodeId]));
    }

    public function destroy($questId, $episodeId)
    {
        if (!$this->questService->isOwnQuest($questId)) {
            throw new BadRequestHttpException();
        }

        $this->episodeService->destroy($questId, $episodeId);

        return redirect(route('all_episodes', ['questId' => $questId]));
    }
}
