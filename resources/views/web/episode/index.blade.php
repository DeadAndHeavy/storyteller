@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Quests</div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-4">
                        @each('web.episode.partial.episode', $episodes, 'episode')
                        <a href="{{ route('create_episode', ['id' => $quest->id]) }}" class="btn btn-success">Add new episode</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
