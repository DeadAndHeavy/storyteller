@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/questCommentSocket.js') }}"></script>
@endsection

@section('content')
<div class="container" id="quest_container" data-quest_id="{{ $quest->id }}">
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
                            <td>{{ $quest->author->name }}</td>
                        </tr>
                        @if (Auth::check() && Auth::user()->id == $quest->user_id && $quest->approval)
                            <tr>
                                <td class="col-md-2 text-center vertical-align">Approve status</td>
                                <td class="vertical-align">
                                    {{ \App\Core\Service\QuestApproveService::getApproveStatusList()[$quest->approval->approve_status] }}
                                </td>
                            </tr>
                            @if ($quest->approval->approve_status == \App\Core\Service\QuestApproveService::QUEST_APPROVE_STATUS_REJECTED)
                                <tr class="danger">
                                    <td class="col-md-2 text-center vertical-align">Reject reason</td>
                                    <td>{{ $quest->approval->message }}</td>
                                </tr>
                            @endif
                        @endif
                    </table>
                    <div>
                        <a href="{{ route('own_quests') }}" class="btn btn-default" title="Back to own quests">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to own quests
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
                                @if ($quest->approval)
                                    @if ($quest->approval->approve_status == \App\Core\Service\QuestApproveService::QUEST_APPROVE_STATUS_REJECTED)
                                        <form class="submit_for_approving" style="display:inline" role="form" action="{{ route('submit_for_approving', ['questId' => $quest->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-success" title="Submit for approving again">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Submit for approving again
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form class="submit_for_approving" style="display:inline" role="form" action="{{ route('submit_for_approving', ['questId' => $quest->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success" title="Submit for approving">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Submit for approving
                                        </button>
                                    </form>
                                @endif
                            @endif
                            <a href="{{ route('play_quest', ['questId' => $quest->id]) }}" class="btn btn-info" title="Play quest">
                                <span class="glyphicon glyphicon-play" aria-hidden="true"></span> Play
                            </a>
                        @endif
                    </div>
                    <hr>
                    <div>
                        <div class="col-md-12" id="quest_comments_container">
                            @each('web.quest.partial.quest_comment', $quest->comments, 'comment')
                        </div>
                        @if (Auth::check())
                            <div class="col-md-12">
                                <form id="quest_comments_form" class="form-horizontal" role="form" method="POST" action="{{ route('comment_quest', ['questId' => $quest->id]) }}">
                                    {{ csrf_field() }}
                                    <input id="user_id" type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input id="quest_id" type="hidden" name="quest_id" value="{{ $quest->id }}">

                                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                        <label for="comment" class="col-md-2 control-label">Quest comment</label>

                                        <div class="col-md-8">
                                            <textarea id="comment" class="form-control" noresize maxlength="2000" rows="8" spellcheck="false" name="comment">{{ old('comment') }}</textarea>

                                            @if ($errors->has('comment'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-2">
                                            <button type="submit" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Add comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
