@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Manage quest scenario</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#variables" aria-controls="variables" role="tab" data-toggle="tab"><h4>Variables</h4></a>
                                </li>
                                <li role="presentation">
                                    <a href="#scenario" aria-controls="scenario" role="tab" data-toggle="tab"><h4>Scenario Steps</h4></a>
                                </li>
                            </ul>

                            <div class="tab-content margin-top-30">
                                <div role="tabpanel" class="tab-pane active" id="variables">
                                    <div class="bottom-buffer" id="quest_variables">
                                        @if (count($questVariables))
                                            <table id="quest_variables_table" class="table table-bordered">
                                                <thead>
                                                <tr class="active">
                                                    <th class="text-center vertical-align">Title</th>
                                                    <th class="text-center vertical-align">Type</th>
                                                    <th class="text-center vertical-align">Default value</th>
                                                    <th class="text-center vertical-align">Track state</th>
                                                    <th class="text-center vertical-align">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @each('web.scenario.partial.variable', $questVariables, 'variable')
                                                </tbody>
                                            </table>
                                        @else
                                            No variables
                                        @endif
                                    </div>
                                    <form class="form-horizontal" role="form" method="POST" action="{{ route('save_variables', ['questId' => $questId]) }}">
                                        {{ csrf_field() }}
                                        <div id="quest_variables_container">
                                            @if (old('variables_list'))
                                                @foreach (old('variables_list') as $variableIndex => $variableData)
                                                    @include('web.scenario.partial.rendered_variable', [
                                                        'variable_index' => $variableIndex,
                                                        'title' => isset($variableData->title) ? $variableData->title : '',
                                                        'type' => isset($variableData->type) ? $variableData->type : '',
                                                        'default_value' => isset($variableData->default_value) ? $variableData->default_value : '',
                                                ])
                                                @endforeach
                                            @endif
                                        </div>
                                        <button id="add_quest_variable" data-quest_id="{{ $questId }}" class="btn btn-success" type="button">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new variable
                                        </button>

                                        <div class="control-buttons top-buffer">
                                            <a href="{{ route('own_quests') }}" class="btn btn-default">
                                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to own quests
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save new variables
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="scenario">
                                    trololo
                                </div>
                            </div>
                        </div>
                            <!--<table id="scenario_table" class="table table-bordered table-responsive">
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
                            </table>-->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
