<form class="form-horizontal update_quest_comment_form" role="form" method="POST" action="{{ route('update_quest_comment', ['questId' => $comment->quest_id, 'commentId' => $comment->id]) }}">
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