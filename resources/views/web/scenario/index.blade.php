@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/scenario.js') }}"></script>
@endsection

@section('content')
    <div id="quest_logic_page" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Manage quest scenario</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation">
                                    <a href="#variables" aria-controls="variables" role="tab" data-toggle="tab"><h4>Variables</h4></a>
                                </li>
                                <li role="presentation" class="active">
                                    <a href="#scenario" aria-controls="scenario" role="tab" data-toggle="tab"><h4>Scenario Steps</h4></a>
                                </li>
                            </ul>

                            <div class="tab-content margin-top-30">
                                <div role="tabpanel" class="tab-pane" id="variables">
                                    <div class="bottom-buffer" id="quest_variables">
                                        @if (count($questVariables))
                                            <table id="quest_variables_table" class="table table-bordered">
                                                <thead>
                                                <tr class="active">
                                                    <th class="text-center vertical-align col-md-3">Title</th>
                                                    <th class="text-center vertical-align col-md-2">Type</th>
                                                    <th class="text-center vertical-align col-md-3">Default value</th>
                                                    <th class="text-center vertical-align col-md-1">Track state</th>
                                                    <th class="text-center vertical-align col-md-2">Actions</th>
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
                                            <button id="save_new_variables" type="submit" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save new variables
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="scenario">
                                    <div class="panel-group" id="episodes_accordion" role="tablist" aria-multiselectable="true">
                                        @foreach ($episodes as $key => $episode)
                                            <div class="panel panel-default">
                                                <div class="panel-heading without-padding" role="tab" id="episode_heading_{{ $episode->id }}">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#episodes_accordion" href="#episode_collapse_{{ $episode->id }}" aria-expanded="true" aria-controls="episode_collapse_{{ $episode->id }}">
                                                            {{ $episode->title }}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="episode_collapse_{{ $episode->id }}" class="panel-collapse collapse {{ $key == 0 ? 'in' : '' }}" role="tabpanel" aria-labelledby="episode_heading_{{ $episode->id }}">
                                                    <div class="panel-body">
                                                        <div class="episode_logic" data-episode-id="{{ $episode->id }}">
                                                            <div class="episode_logic_screen col-md-6 panel panel-default">
                                                                <div class="panel-body">
                                                                    <div class="logic_row active"></div>
                                                                </div>
                                                            </div>
                                                            <div class="episode_logic_operations col-md-6">
                                                                <div class="variables_list">
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            Add variable <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            @foreach ($questVariables as $variable)
                                                                                <li>
                                                                                    <a class="add-logic-var-button" href="javascript:void(0);" data-variable-title="{{ $variable->title }}" data-variable-id="{{ $variable->id }}">{{ $variable->title }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                    <button type="button" class="btn btn-default add-logic-assignment-button">=</button>
                                                                    <button type="button" class="btn btn-default add-logic-new-line-button">
                                                                        <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                                                                    </button>
                                                                    <button type="button" data-toggle="modal" data-target="#removeEpisodeLogicModal" class="btn btn-danger add-logic-remove-all-button">
                                                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                                    </button>
                                                                    <button type="button" class="btn btn-default enable_removing_tool">
                                                                        <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
                                                                    </button>
                                                                    <button type="button" class="btn btn-default add-logic-if-button">IF</button>
                                                                    <button type="button" class="btn btn-default add-logic-else-button">ELSE</button>
                                                                    <button type="button" class="btn btn-default add-logic-elseif-button">ELSEIF</button>
                                                                    <button type="button" class="btn btn-default add-logic-endif-button">ENDIF</button>
                                                                    <button type="button" class="btn btn-default add-logic-left-bracket-button">(</button>
                                                                    <button type="button" class="btn btn-default add-logic-right-bracket-button">)</button>
                                                                    <button type="button" class="btn btn-default add-logic-plus-button">+</button>
                                                                    <button type="button" class="btn btn-default add-logic-minus-button">-</button>
                                                                    <button type="button" class="btn btn-default add-logic-multiplication-button">*</button>
                                                                    <button type="button" class="btn btn-default add-logic-division-button">/</button>
                                                                    <button type="button" class="btn btn-default add-logic-equal-button">==</button>
                                                                    <button type="button" class="btn btn-default add-logic-not-equal-button">!=</button>
                                                                    <button type="button" class="btn btn-default add-logic-greater-button">></button>
                                                                    <button type="button" class="btn btn-default add-logic-greater-or-equal-button">>=</button>
                                                                    <button type="button" class="btn btn-default add-logic-lower-button"><</button>
                                                                    <button type="button" class="btn btn-default add-logic-lower-or-equal-button"><=</button>
                                                                    <button type="button" class="btn btn-default add-logic-and-button">AND</button>
                                                                    <button type="button" class="btn btn-default add-logic-or-button">OR</button>
                                                                    <button type="button" class="btn btn-default add-logic-not-button">NOT</button>
                                                                    <button type="button" class="btn btn-default add-logic-value-button">VALUE</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
@include('web/modal/remove_all_episode_logic')
@endsection