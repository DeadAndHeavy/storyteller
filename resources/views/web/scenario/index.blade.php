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
                                @foreach ($episodes as $episode)
                                    <tr>
                                        <td class="vertical-align">{{ $episode->title }}</td>
                                        <td class="text-center vertical-align">{{ $episode->type }}</td>
                                        <td class="vertical-align">
                                            <table class="table-bordered">
                                                @foreach ($episode->episodeActions as $episodeAction)
                                                    <tr>
                                                        <td class="col-md-8">{{ $episodeAction->content }}</td>
                                                        <td class="col-md-4">
                                                            <select name="scenario_episode_action_target_id[{{ $episodeAction->id }}]" class="form-control col-md-4">
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
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="control-buttons">
                                <a href="{{ url('/quest/own') }}" class="btn btn-info">
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
