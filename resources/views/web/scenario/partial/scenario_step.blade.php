<div align="justify" class="col-md-8 col-md-offset-2 top-buffer-2 bottom-buffer-2">
    {!! $episode->content !!}
</div>
<div class="col-md-8 col-md-offset-2 top-buffer-2 bottom-buffer-2">
    @if ($episode->type != \App\Core\Service\EpisodeService::EPISODE_TYPE_FINISH)
        @foreach ($episode->episodeActions as $episodeAction)
            <a class="episodeActionProcess" data-target-episode-id="{{ $episodeAction->target_episode_id }}" href="javascript:void(0)">{{ $episodeAction->content }}</a><br>
        @endforeach
    @else
        @foreach ($episode->episodeActions as $episodeAction)
            <a class="episodeActionProcess" href="{{ route('own_quests') }}">{{ $episodeAction->content }}</a><br>
        @endforeach
    @endif
</div>