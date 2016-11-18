@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 quest-episode-zone">
                @include('web/scenario/partial/scenario_step', ['episode' => $startEpisode])
            </div>
        </div>
    </div>
@endsection
