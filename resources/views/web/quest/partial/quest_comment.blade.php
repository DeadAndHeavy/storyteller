<div class="col-md-12 comment">
    <div class="col-md-2 author">
        <div class="name"><b>{{ $comment->user->name }}</b></div>
        <div class="time">{{ $comment->created_at }}</div>
    </div>
    <div class="col-md-10 well well-lg comment_area" data-comment_id="{{ $comment->id }}">
        <div class="col-md-10">
            <div class="comment_content">{{ $comment->comment }}</div>
            <form id="update_quest_comment_form_{{ $comment->id }}" class="form-horizontal update_quest_comment_form" role="form" method="POST" action="{{ route('update_quest_comment', ['questId' => $comment->quest_id, 'commentId' => $comment->id]) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                <input id="quest_id" type="hidden" name="quest_id" value="{{ $comment->quest_id }}">
                <input id="user_id" type="hidden" name="user_id" value="{{ $comment->user_id }}">

                <div class="form-group">
                    <div class="col-md-12">
                        <textarea class="form-control" noresize maxlength="2000" rows="4" spellcheck="false" name="comment">{{ $comment->comment }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update comment
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @if (Auth::check() && $comment->user_id == Auth::user()->id)
            <div class="col-md-2">
                <form class="delete_quest_comment_form" style="display:inline" role="form" action="{{ route('delete_quest_comment', ['questId' => $comment->quest_id, 'commentId' => $comment->id]) }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    {{ csrf_field() }}
                    <button onclick="return confirm('Are you sure you want to delete this comment?');" type="submit" class="btn btn-sm btn-danger" title="Delete comment">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </form>
                <button type="button" data-comment_id="{{ $comment->id }}" class="btn btn-sm btn-primary update_quest_comment" title="Update comment">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
            </div>
        @endif
    </div>
</div>