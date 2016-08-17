@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Manage quest scenario</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('save_scenario', ['questId' => $questId]) }}">
                            <div class="control-buttons">
                                <button id="add_scenario_step" data-quest_id="{{ $questId }}" class="btn btn-success add_scenario_step" type="button">
                                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add new step
                                </button>
                                <a href="{{ url('/quest/own') }}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to own quests
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save changes
                                </button>
                            </div>
                            {{ csrf_field() }}
                            <div id="scenario_steps" class="">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
