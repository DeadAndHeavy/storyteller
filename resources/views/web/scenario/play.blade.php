@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div id="play-zone" class="panel-body">
                        <div class="quest-episode-zone">
                            @include('web/scenario/partial/scenario_step', ['episode' => $startEpisode])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
