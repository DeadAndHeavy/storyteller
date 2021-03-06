@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/questCommentSocket.js') }}"></script>
@endsection

@section('content')
<div class="container" id="quest_container" data-quest_id="{{ $quest->id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading quest-heading-panel">{{ $quest->name }}</div>
                <div class="panel-body">
                    <div class="col-md-12 margin-tb-20">
                        <div class="col-md-3 quest-body-image">
                            <img src="{{ URL::asset('quests_images/' . $quest->id . '/quest_logo.jpg?mt=' . $imageModificationTime) }}">
                            <div class="quest-body-genre margin-top-15"><b>Genre:</b> {{ \App\Core\Service\QuestService::getAllQuestGenres()[$quest->genre] }}</div>
                            <div class="quest-body-author"><b>Author:</b> {{ $quest->author->name }}</div>
                            @if (Auth::check() && Auth::user()->id == $quest->user_id && $quest->approval)
                                <div class="quest-body-approve-status">
                                    <b>Approve status:</b> <span class="approve-status-{{ $quest->approval->approve_status }}"><b>{{ \App\Core\Service\QuestApproveService::getApproveStatusList()[$quest->approval->approve_status] }}</b></span>
                                </div>
                                @if ($quest->approval->approve_status == \App\Core\Service\QuestApproveService::QUEST_APPROVE_STATUS_REJECTED)
                                    <div class="quest-body-reject-reason approve-status-{{ $quest->approval->approve_status }}"><b>Reject reason:</b> {{ $quest->approval->message }}</div>
                                @endif
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="quest-body-description">{!! $quest->description !!}</div>
                        </div>
                    </div>
                    <div class="col-md-12 quest-body-buttons-bar">
                        <a href="{{ route('play_quest', ['questId' => $quest->id]) }}" class="btn btn-info" title="Play quest">
                            <span class="glyphicon glyphicon-play" aria-hidden="true"></span> Play
                        </a>
                        @if (Auth::check())
                            @if (Auth::user()->id == $quest->user_id)
                                <a href="{{ route('edit_quest', ['questId' => $quest->id]) }}" class="btn btn-primary" title="Update quest info">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                </a>
                                <a href="{{ route('all_episodes', ['questId' => $quest->id]) }}" class="btn btn-primary" title="Manage quest episodes">
                                    <span class="glyphicon glyphicon-film" aria-hidden="true"></span> Episodes
                                </a>
                                <a href="{{ route('scenario', ['questId' => $quest->id]) }}" class="btn btn-primary" title="Quest logic">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Quest logic
                                </a>
                                @if ($quest->approval)
                                    @if ($quest->approval->approve_status == \App\Core\Service\QuestApproveService::QUEST_APPROVE_STATUS_REJECTED)
                                        <form class="submit_for_approving" style="display:inline" role="form" action="{{ route('submit_for_approving', ['questId' => $quest->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary" title="Submit for approving again">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Approve request
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form class="submit_for_approving" style="display:inline" role="form" action="{{ route('submit_for_approving', ['questId' => $quest->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-primary" title="Submit for approving">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Approve request
                                        </button>
                                    </form>
                                @endif
                                <form class="delete_quest" style="display:inline" role="form" action="{{ route('delete_quest', ['questId' => $quest->id]) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <button onclick="return confirm('Are you sure you want to delete this quest?');" type="submit" class="btn btn-danger" title="Delete quest">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-12 margin-top-30" id="quest_comments_container">
                        <hr>
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
@endsection
