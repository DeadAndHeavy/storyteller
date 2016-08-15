@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Episodes</div>
                <div class="panel-body">
                    <div class="control-buttons">
                        <a href="{{ route('create_episode', ['id' => $questId]) }}" class="btn btn-success">Add new episode</a>
                    </div>
                    <div class="top-buffer" id="episodes">
                        @if (count($episodes))
                            <table class="table table-bordered">
                                <tr class="active">
                                    <td class="col-md-1 text-center vertical-align">Episode id</td>
                                    <td class="col-md-4 text-center vertical-align">Episode title</td>
                                    <td class="col-md-1 text-center vertical-align">Actions count</td>
                                    <td class="col-md-2 text-center vertical-align">Actions</td>
                                </tr>
                                @each('web.episode.partial.episode', $episodes, 'episode')
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
