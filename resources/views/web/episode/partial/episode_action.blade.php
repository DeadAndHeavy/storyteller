<div class="episode_action episode_action_{{ $action_index }} form-group{{ $errors->has('action_content_list.' . $action_index) ? ' has-error' : '' }}">
    <label for="action_content_list[{{ $action_index }}]" class="col-md-2 control-label">Episode action {{ $action_index }}</label>

    <div class="col-md-10">
        <input id="action_content_{{ $action_index }}" name="action_content_list[{{ $action_index }}]" type="text" class="form-control" value="{{ $action_content }}">
        @if ($errors->has('action_content_list.' . $action_index))
            <span class="help-block">
                <strong>{{ $errors->first('action_content_list.' . $action_index) }}</strong>
            </span>
        @endif
    </div>
    <!--<div class="col-md-2">
        <select id="target_{{ $action_index }}" name="target[{{ $action_index }}]" class="form-control">
            <option disabled selected>@lang('episode.choose_target')</option>
            @foreach ($episodes as $episode)
                @if (old("target[{{ $action_index }}]") == $episode->id)
                    <option selected value="{{ $episode->id }}">{{ $episode->id }}</option>
                @else
                    <option value="{{ $episode->id }}">{{ $episode->id }}</option>
                @endif
            @endforeach
        </select>
    </div>-->
</div>