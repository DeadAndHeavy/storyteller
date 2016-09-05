<div class="col-md-12 comment">
    <div class="col-md-2 author">
        <div class="name"><b>{{ $comment->user->name }}</b></div>
        <div class="time">{{ $comment->created_at }}</div>
    </div>
    <div class="col-md-10 well well-lg comment_area">
        <div class="col-md-11 comment_content" data-comment_id="{{ $comment->id }}">{{ $comment->comment }}</div>
        @if ($comment->user_id == Auth::user()->id)
            <div class="col-md-1">
                <button type="button" data-comment_id="{{ $comment->id }}" class="btn btn-sm btn-primary update_quest_comment" title="Update comment">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <form class="delete_comment" style="display:inline" role="form" action="{{ route('delete_quest', ['questId' => $comment->id]) }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    {{ csrf_field() }}
                    <button onclick="return confirm('Are you sure you want to delete this comment?');" type="button" class="top-buffer-5 btn btn-sm btn-danger" title="Delete comment">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>