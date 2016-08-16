<div class="scenario_step  panel panel-default col-md-12 col-md-offset-1 top-buffer alert-info">
    <div class="panel-body">
        <div class="form-group col-md-6">
            <select data-quest_id="{{ $questId }}" class="form-control scenario-episode-selector">
                <option disabled selected>@lang('scenario.choose_episode')</option>
                @foreach ($episodes as $episode)
                    <option value="{{ $episode->id }}">{{ $episode->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-12">
            <div class="panel panel-default episode-content">
                <div class="panel-body">
                    @if ($currentEpisode)
                        {{ $currentEpisode->content }}
                    @else
                        Select the episode and its contents will appear here
                    @endif
                </div>
            </div>
            @if ($currentEpisode)
                @foreach ($currentEpisode->episodeActions as $currentEpisodeAction)
                <div class="panel panel-info episode-actions">
                    <div class="panel-body">
                        {{ $currentEpisodeAction->content }}
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
