<div class="col-md-8">
    <div id="game-content" align="justify">{!! $episode->content !!}</div>
    <div id="game-actions">
        @if ($episode->type != \App\Core\Service\EpisodeService::EPISODE_TYPE_FINISH)
            @foreach ($episode->episodeActions as $key => $episodeAction)
                <p><a class="episodeActionProcess {{ $key > 0 ? 'margin-top-small' : '' }}" data-target-episode-id="{{ $episodeAction->target_episode_id }}" href="javascript:void(0)">{{ $episodeAction->content }}</a></p>
            @endforeach
        @else
            @foreach ($episode->episodeActions as $episodeAction)
                <p><a class="episodeActionProcess finish_action" href="{{ route('finish_quest', ['questId' => $episode->quest_id]) }}">{{ $episodeAction->content }}</a></p>
            @endforeach
        @endif
    </div>
</div>
<div class="col-md-4">
    <div id="game-image">
        <img class="" src="{{ URL::asset('quests_images/' . $episode->quest_id . '/' . $episode->id . '.jpg?mt=' . $imageModificationTime) }}">
    </div>
    <div id="game-states">states</div>
</div>
