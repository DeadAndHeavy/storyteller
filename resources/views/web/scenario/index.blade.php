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
                                    <form class="form-horizontal" role="form" method="POST" action="{{ route('save_variables', ['questId' => $quest->id]) }}">
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
                                        <button id="add_quest_variable" data-quest_id="{{ $quest->id }}" class="btn btn-success" type="button">
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
                                    <form id="save_scenario" class="form-horizontal" role="form" method="POST" action="{{ route('save_scenario', ['questId' => $quest->id]) }}">
                                        {{ csrf_field() }}
                                        @foreach ($episodes as $episodeIndex => $episode)
                                            <div class="panel-group episode_container col-md-12" id="episode_{{ $episode->id }}_accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading without-padding" role="tab" id="episode_heading_{{ $episode->id }}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#episode_{{ $episode->id }}_accordion" href="#episode_collapse_{{ $episode->id }}" aria-expanded="true" aria-controls="episode_collapse_{{ $episode->id }}">
                                                                <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
                                                                {{ $episode->title }}
                                                                @if ($episode->type == \App\Core\Service\EpisodeService::EPISODE_TYPE_START)
                                                                    <span class="glyphicon glyphicon-home float-right cursor-pointer" aria-hidden="true" title="Start episode"></span>
                                                                @endif
                                                                @if ($episode->type == \App\Core\Service\EpisodeService::EPISODE_TYPE_FINISH)
                                                                    <span class="glyphicon glyphicon-flag float-right cursor-pointer" aria-hidden="true" title="Finish episode"></span>
                                                                @endif
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="episode_collapse_{{ $episode->id }}" class="panel-collapse collapse {{ $episodeIndex == 0 ? 'in' : '' }}" role="tabpanel" aria-labelledby="episode_heading_{{ $episode->id }}">
                                                        <div class="panel-body">
                                                            @if ($episode->type == \App\Core\Service\EpisodeService::EPISODE_TYPE_START)
                                                                <div class="panel-group init_logic_accordion col-md-12" id="init_logic_accordion" role="tablist" aria-multiselectable="true">
                                                                    <div class="panel panel-{{ $episodeActionsValidationList['init'] ? 'success' : 'danger' }}">
                                                                        <div class="panel-heading without-padding" role="tab" id="init_logic_heading">
                                                                            <h4 class="panel-title">
                                                                                <a role="button" data-toggle="collapse" data-parent="#init_logic_accordion" href="#init_logic_collapse" aria-expanded="true" aria-controls="init_logic_collapse">
                                                                                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                                                                    Init logic
                                                                                </a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="init_logic_collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="init_logic_heading">
                                                                            <div class="panel-body">
                                                                                <h4 class="text-center">Init logic</h4>
                                                                                <hr>
                                                                                <div class="init_logic logic_container col-md-12" data-episode-action-id=0>
                                                                                    <div class="col-md-6">
                                                                                        <div class="logic_container_screen panel panel-default">
                                                                                            <div class="panel-body">
                                                                                                @if ($quest->init_logic)
                                                                                                    {!! $quest->init_logic !!}
                                                                                                @else
                                                                                                    <div class="logic_row active"></div>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="logic_screen_utilities top-buffer-5">
                                                                                            <button type="button" data-toggle="modal" data-target="#removeEpisodeActionLogicModal" class="btn btn-danger add-logic-remove-all-button">
                                                                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-default enable_removing_tool" title="removing tool">
                                                                                                <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="episode_action_logic_operations col-md-6">
                                                                                        <div class="operation_buttons_set variables_list">
                                                                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add variables or values.">
                                                                                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-primary add-logic-var-button">VARIABLE</button>
                                                                                            <button type="button" class="btn btn-primary add-logic-value-button">VALUE</button>
                                                                                        </div>
                                                                                        <div class="operation_buttons_set condition_elements_list">
                                                                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add condition elements">
                                                                                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-success add-logic-if-button">IF</button>
                                                                                            <button type="button" class="btn btn-success add-logic-else-button">ELSE</button>
                                                                                            <button type="button" class="btn btn-success add-logic-elseif-button">ELSEIF</button>
                                                                                            <button type="button" class="btn btn-success add-logic-left-brace-button">{</button>
                                                                                            <button type="button" class="btn btn-success add-logic-right-brace-button">}</button>
                                                                                        </div>
                                                                                        <div class="operation_buttons_set comparison_operations_list">
                                                                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add comparison operators">
                                                                                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-warning add-logic-equal-button">==</button>
                                                                                            <button type="button" class="btn btn-warning add-logic-not-equal-button">!=</button>
                                                                                            <button type="button" class="btn btn-warning add-logic-greater-button">></button>
                                                                                            <button type="button" class="btn btn-warning add-logic-greater-or-equal-button">>=</button>
                                                                                            <button type="button" class="btn btn-warning add-logic-lower-button"><</button>
                                                                                            <button type="button" class="btn btn-warning add-logic-lower-or-equal-button"><=</button>
                                                                                        </div>
                                                                                        <div class="operation_buttons_set logical_operations_list">
                                                                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add logical operators">
                                                                                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-warning add-logic-and-button">AND</button>
                                                                                            <button type="button" class="btn btn-warning add-logic-or-button">OR</button>
                                                                                            <button type="button" class="btn btn-warning add-logic-not-button">NOT</button>
                                                                                        </div>
                                                                                        <div class="operation_buttons_set arithmetic_operations_list">
                                                                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add arithmetic operators">
                                                                                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-info add-logic-plus-button">+</button>
                                                                                            <button type="button" class="btn btn-info add-logic-minus-button">-</button>
                                                                                            <button type="button" class="btn btn-info add-logic-multiplication-button">*</button>
                                                                                            <button type="button" class="btn btn-info add-logic-division-button">/</button>
                                                                                            <button type="button" class="btn btn-info add-logic-plus-equal-button">+=</button>
                                                                                            <button type="button" class="btn btn-info add-logic-minus-equal-button">-=</button>
                                                                                            <button type="button" class="btn btn-info add-logic-multiplication-equal-button">*=</button>
                                                                                            <button type="button" class="btn btn-info add-logic-division-equal-button">/=</button>
                                                                                        </div>
                                                                                        <div class="operation_buttons_set additional_operations_list">
                                                                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add addition elements">
                                                                                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-default add-logic-assignment-button">=</button>
                                                                                            <button type="button" class="btn btn-default add-logic-new-line-button">
                                                                                                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-default add-logic-indent-button">INDENT</button>
                                                                                            <button type="button" class="btn btn-default add-logic-left-bracket-button">(</button>
                                                                                            <button type="button" class="btn btn-default add-logic-right-bracket-button">)</button>
                                                                                            <button type="button" class="btn btn-default add-logic-end-of-operator-button">;</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @foreach ($episode->episodeActions as $episodeActionIndex => $episodeAction)
                                                                <div class="panel-group episode_actions_accordion col-md-12" id="episode_action_{{ $episodeAction->id }}_accordion" role="tablist" aria-multiselectable="true">
                                                                    <div class="panel panel-{{ $episodeActionsValidationList[$episodeAction->id] ? 'success' : 'danger' }}">
                                                                        <div class="panel-heading without-padding" role="tab" id="episode_action_heading_{{ $episodeAction->id }}">
                                                                            <h4 class="panel-title">
                                                                                <a role="button" data-toggle="collapse" data-parent="#episode_action_{{ $episodeAction->id }}_accordion" href="#episode_action_collapse_{{ $episodeAction->id }}" aria-expanded="true" aria-controls="episode_action_collapse_{{ $episodeAction->id }}">
                                                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                                                    {{ $episodeAction->content }}
                                                                                </a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="episode_action_collapse_{{ $episodeAction->id }}" class="panel-collapse collapse {{ $episodeActionIndex == 0 ? 'in' : '' }}" role="tabpanel" aria-labelledby="episode_action_heading_{{ $episodeAction->id }}">
                                                                            <div class="panel-body">
                                                                                @if ($episode->type != \App\Core\Service\EpisodeService::EPISODE_TYPE_FINISH)
                                                                                    <h4 class="text-center">Episode Action logic</h4>
                                                                                    <hr>
                                                                                    <div class="logic_container col-md-12" data-episode-action-id="{{ $episodeAction->id }}">
                                                                                        <div class="col-md-6">
                                                                                            <div class="logic_container_screen panel panel-default">
                                                                                                <div class="panel-body">
                                                                                                    @if ($episodeAction->logic)
                                                                                                        {!! $episodeAction->logic !!}
                                                                                                    @else
                                                                                                        <div class="logic_row active"></div>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="logic_screen_utilities top-buffer-5">
                                                                                                <button type="button" data-toggle="modal" data-target="#removeEpisodeActionLogicModal" class="btn btn-danger add-logic-remove-all-button">
                                                                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-default enable_removing_tool" title="removing tool">
                                                                                                    <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="episode_action_logic_operations col-md-6">
                                                                                            <div class="operation_buttons_set variables_list">
                                                                                                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add variables or values. You can add new variables on 'Variables' tab">
                                                                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-primary add-logic-var-button">VARIABLE</button>
                                                                                                <button type="button" class="btn btn-primary add-logic-value-button">VALUE</button>
                                                                                            </div>
                                                                                            <div class="operation_buttons_set condition_elements_list">
                                                                                                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add condition elements">
                                                                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-success add-logic-if-button">IF</button>
                                                                                                <button type="button" class="btn btn-success add-logic-else-button">ELSE</button>
                                                                                                <button type="button" class="btn btn-success add-logic-elseif-button">ELSEIF</button>
                                                                                                <button type="button" class="btn btn-success add-logic-left-brace-button">{</button>
                                                                                                <button type="button" class="btn btn-success add-logic-right-brace-button">}</button>
                                                                                            </div>
                                                                                            <div class="operation_buttons_set comparison_operations_list">
                                                                                                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add comparison operators">
                                                                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-warning add-logic-equal-button">==</button>
                                                                                                <button type="button" class="btn btn-warning add-logic-not-equal-button">!=</button>
                                                                                                <button type="button" class="btn btn-warning add-logic-greater-button">></button>
                                                                                                <button type="button" class="btn btn-warning add-logic-greater-or-equal-button">>=</button>
                                                                                                <button type="button" class="btn btn-warning add-logic-lower-button"><</button>
                                                                                                <button type="button" class="btn btn-warning add-logic-lower-or-equal-button"><=</button>
                                                                                            </div>
                                                                                            <div class="operation_buttons_set logical_operations_list">
                                                                                                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add logical operators">
                                                                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-warning add-logic-and-button">AND</button>
                                                                                                <button type="button" class="btn btn-warning add-logic-or-button">OR</button>
                                                                                                <button type="button" class="btn btn-warning add-logic-not-button">NOT</button>
                                                                                            </div>
                                                                                            <div class="operation_buttons_set arithmetic_operations_list">
                                                                                                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add arithmetic operators">
                                                                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-info add-logic-plus-button">+</button>
                                                                                                <button type="button" class="btn btn-info add-logic-minus-button">-</button>
                                                                                                <button type="button" class="btn btn-info add-logic-multiplication-button">*</button>
                                                                                                <button type="button" class="btn btn-info add-logic-division-button">/</button>
                                                                                                <button type="button" class="btn btn-info add-logic-plus-equal-button">+=</button>
                                                                                                <button type="button" class="btn btn-info add-logic-minus-equal-button">-=</button>
                                                                                                <button type="button" class="btn btn-info add-logic-multiplication-equal-button">*=</button>
                                                                                                <button type="button" class="btn btn-info add-logic-division-equal-button">/=</button>
                                                                                            </div>
                                                                                            <div class="operation_buttons_set additional_operations_list">
                                                                                                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Add addition elements">
                                                                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-default add-logic-assignment-button">=</button>
                                                                                                <button type="button" class="btn btn-default add-logic-new-line-button">
                                                                                                    <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-default add-logic-indent-button">INDENT</button>
                                                                                                <button type="button" class="btn btn-default add-logic-left-bracket-button">(</button>
                                                                                                <button type="button" class="btn btn-default add-logic-right-bracket-button">)</button>
                                                                                                <button type="button" class="btn btn-default add-logic-end-of-operator-button">;</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    @if ($episode->type != \App\Core\Service\EpisodeService::EPISODE_TYPE_FINISH)
                                                                                        <div class="col-md-12">
                                                                                            <h4 class="text-center">Episode action target</h4>
                                                                                            <hr>
                                                                                            <select id="type" name="episode_action[{{ $episodeAction->id }}][target_episode_id]" class="form-control">
                                                                                                <option disabled selected>Choose target episode</option>
                                                                                                @foreach ($episodes as $episodeElement)
                                                                                                    @if ($episodeElement->id == $episodeAction->target_episode_id)
                                                                                                        <option selected value="{{ $episodeElement->id }}">{{ $episodeElement->title }}</option>
                                                                                                    @else
                                                                                                        <option value="{{ $episodeElement->id }}">{{ $episodeElement->title }}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    @endif
                                                                                @else
                                                                                    Finish episode actions don't have logic
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save scenario
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('web/modal/remove_all_episode_logic')
@endsection