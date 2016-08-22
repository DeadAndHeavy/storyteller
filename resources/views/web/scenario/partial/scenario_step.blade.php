<div class="top-buffer scenario_step">
    <hr/>
    <div class="">
        <h3>Episode section</h3>
    </div>
    <div class="panel panel-default alert-info">
        <div class="panel-body">
            <div class="col-md-12 form-group">
                <label for="name" class="col-md-1 control-label">Episode</label>
                <div class="col-md-4">
                    <select data-quest_id="{{ $questId }}" class="form-control scenario-episode-selector">
                        <option disabled selected>@lang('scenario.choose_episode')</option>
                        @foreach ($episodes as $episode)
                            @if ($currentEpisode && $episode->id == $currentEpisode->id)
                                <option selected value="{{ $episode->id }}">{{ $episode->title }}</option>
                            @else
                                <option value="{{ $episode->id }}">{{ $episode->title }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-danger pull-right remove_scenario_step" title="Delete scenario step">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
            @if ($currentEpisode)
                <div class="col-md-12 form-group">
                    <label class="col-md-1 control-label">Content</label>
                    <div class="col-md-11">
                        <div class="panel episode-content ">
                            <div class="panel-body">
                                {{ $currentEpisode->content }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-1 control-label">Actions</label>
                    <div class="col-md-11">
                        @foreach ($currentEpisode->episodeActions as $currentEpisodeAction)
                            <div class="col-md-8">
                                <div class="episode_action_content">
                                    <div class="panel episode-content ">
                                        <div class="panel-body">
                                            <span class="text-success">{{ $currentEpisodeAction->content }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="scenario_episode_action_target_id[{{ $currentEpisodeAction->id }}]" class="form-control">
                                    <option disabled selected>@lang('scenario.choose_target')</option>
                                    @foreach ($episodes as $episode)
                                        @if ($episode->id == $currentEpisodeAction->target_episode_id)
                                            <option selected value="{{ $episode->id }}">{{ $episode->title }}</option>
                                        @else
                                            <option value="{{ $episode->id }}">{{ $episode->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
