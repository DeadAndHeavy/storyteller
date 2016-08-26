@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Manage quest scenario</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('save_scenario', ['questId' => $questId]) }}">
                            {{ csrf_field() }}
                            <table id="scenario_table" class="table table-bordered table-responsive">
                                <thead>
                                <tr class="active">
                                    <th class="col-md-3 text-center">Episode title</th>
                                    <th class="col-md-1 text-center">Type</th>
                                    <th class="col-md-8 text-center">Action targets</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($episodes as $currentEpisode)
                                    <tr>
                                        <td class="vertical-align">{{ $currentEpisode->title }}</td>
                                        <td class="text-center vertical-align">{{ $currentEpisode->type }}</td>
                                        <td class="vertical-align">
                                            <div class="col-md-12">
                                                <table class="table table-bordered without-vertical-buffer">
                                                    @foreach ($currentEpisode->episodeActions as $episodeAction)
                                                        @if ($episodeAction->target_episode_id || $currentEpisode->type == \App\Core\Service\EpisodeService::EPISODE_TYPE_FINISH)
                                                            <tr class="success">
                                                        @else
                                                            <tr class="warning">
                                                        @endif
                                                            <td class="col-md-8 vertical-align">{{ $episodeAction->content }}</td>
                                                            @if ($currentEpisode->type != \App\Core\Service\EpisodeService::EPISODE_TYPE_FINISH)
                                                                <td class="col-md-4">
                                                                    <select name="scenario_episode_action_targets[{{ $episodeAction->id }}]" class="form-control">
                                                                        <option disabled selected>@lang('scenario.choose_target')</option>
                                                                        @foreach ($episodes as $episode)
                                                                            @if ($episode->id == $episodeAction->target_episode_id)
                                                                                <option selected value="{{ $episode->id }}">{{ $episode->title }}</option>
                                                                            @else
                                                                                <option value="{{ $episode->id }}">{{ $episode->title }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="control-buttons top-buffer">
                                <a href="{{ route('own_quests') }}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to own quests
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
