<div class="episode_action form-group{{ $errors->has('actions_list.' . $action_index . '.content') ? ' has-error' : '' }}" data-episode_action_index="{{ $action_index }}">
    <label for="actions_list[{{ $action_index }}][content]" class="col-md-2 control-label">Episode action</label>

    <div class="col-md-9">
        <input name="actions_list[{{ $action_index }}][content]" type="text" class="form-control" value="{{ $action_content }}">
        <input name="actions_list[{{ $action_index }}][action_id]" type="hidden" value="{{ isset($action_id) ? $action_id : null }}">
        @if ($errors->has('actions_list.' . $action_index  . '.content'))
            <span class="help-block">
                <strong>{{ $errors->first('actions_list.' . $action_index  . '.content') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-1">
        <button data-quest_id="{{ $quest_id }}" class="btn btn-danger delete_episode_action" type="button">
            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
        </button>
    </div>
</div>