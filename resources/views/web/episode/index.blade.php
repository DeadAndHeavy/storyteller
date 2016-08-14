@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Episodes</div>
                <div class="panel-body">
                    <div class="control-buttons">
                        <a href="{{ route('create_episode', ['id' => $quest->id]) }}" class="btn btn-success">Add new episode</a>
                    </div>
                    <div class="top-buffer" id="episodes" role="tablist" aria-multiselectable="true">
                        @each('web.episode.partial.episode', $episodes, 'episode')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
