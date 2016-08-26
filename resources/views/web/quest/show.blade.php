@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $quest->name }}</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td class="col-md-2 text-center vertical-align">Quest title</td>
                            <td>{{ $quest->name }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-center vertical-align">Quest description</td>
                            <td>{{ $quest->description }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-center vertical-align">Genre</td>
                            <td>{{ \App\Core\Service\QuestService::getAllQuestGenres()[$quest->genre] }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-center vertical-align">Author</td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-center vertical-align">Approve status</td>
                            <td>{{ $quest->author->name }}</td>
                        </tr>
                    </table>
                    <div>
                        <a href="{{ URL::previous() }}" class="btn btn-default" title="Back to previous page">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
                        </a>
                        @if (Auth::check())
                            @if (Auth::user()->id == $quest->user_id)
                                <a href="{{ route('edit_quest', ['questId' => $quest->id]) }}" class="btn btn-primary" title="Update quest info">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                </a>
                                <a href="{{ route('all_episodes', ['questId' => $quest->id]) }}" class="btn btn-success" title="Manage quest episodes">
                                    <span class="glyphicon glyphicon-film" aria-hidden="true"></span> Episodes
                                </a>
                                <a href="{{ route('scenario', ['questId' => $quest->id]) }}" class="btn btn-epic" title="Quest scenario">
                                    <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Scenario
                                </a>
                                <form class="delete_quest" style="display:inline" role="form" action="{{ route('delete_quest', ['questId' => $quest->id]) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <button onclick="return confirm('Are you sure you want to delete this quest?');" type="submit" class="btn btn-danger" title="Delete quest">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                                    </button>
                                </form>
                                @if (!$quest->inApproveQueue)
                                <form class="approve_quest" style="display:inline" role="form" action="{{ route('approve_quest', ['questId' => $quest->id]) }}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-success" title="Send quest to approving">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Approve
                                    </button>
                                </form>
                                @endif
                            @endif
                            <a href="{{ route('play_quest', ['questId' => $quest->id]) }}" class="btn btn-info" title="Play quest">
                                <span class="glyphicon glyphicon-play" aria-hidden="true"></span> Play
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
