@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Episodes</div>
                <div class="panel-body">
                    <div class="control-buttons">
                        <a href="{{ route('create_episode', ['id' => $questId]) }}" class="btn btn-success">
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add new episode
                        </a>
                        <a href="{{ url('/quest/own') }}" class="btn btn-info">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to own quests
                        </a>
                    </div>
                    <div class="top-buffer" id="episodes">
                        @if (count($episodes))
                            <table id="episodes_table" class="table table-bordered">
                                <thead>
                                <tr class="active">
                                    <th>Episode title</th>
                                    <th>Episode type</th>
                                    <th>Actions count</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @each('web.episode.partial.episode', $episodes, 'episode')
                                </tbody>
                            </table>
                        @else
                            No episodes
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
