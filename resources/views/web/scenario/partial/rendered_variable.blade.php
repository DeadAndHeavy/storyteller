<div class="quest_variable form-group" data-variable_index="{{ $variable_index }}">
    <input name="variables_list[{{ $variable_index }}][quest_id]" type="hidden" value="{{ $questId }}">
    <div class="col-md-3 {{ $errors->has('variables_list.' . $variable_index . '.title') ? 'has-error' : '' }}">
        <input name="variables_list[{{ $variable_index }}][title]" type="text" class="form-control" value="{{ old('variables_list.' . $variable_index . '.title') ? old('variables_list.' . $variable_index . '.title') : '' }}" placeholder="Enter variable title...">
        @if ($errors->has('variables_list.' . $variable_index . '.title'))
            <span class="help-block">
                 <strong>{{ $errors->first('variables_list.' . $variable_index . '.title') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-2 {{ $errors->has('variables_list.' . $variable_index . '.type') ? 'has-error' : '' }}">
        <select name="variables_list[{{ $variable_index }}][type]" class="form-control">
            <option disabled selected>@lang('variable.choose_type')</option>
            @foreach ($variableTypes as $key => $value)
                @if (isset($type) && $type == $value)
                    <option selected value="{{ $key }}">{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
        @if ($errors->has('variables_list.' . $variable_index . '.type'))
            <span class="help-block">
                 <strong>{{ $errors->first('variables_list.' . $variable_index . '.type') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-3 {{ $errors->has('variables_list.' . $variable_index . '.default_value') ? 'has-error' : '' }}">
        <input name="variables_list[{{ $variable_index }}][default_value]" type="text" class="form-control" value="{{ isset($default_value) ? $default_value : '' }}" placeholder="Enter variable default value...">
        @if ($errors->has('variables_list.' . $variable_index . '.default_value'))
            <span class="help-block">
                 <strong>{{ $errors->first('variables_list.' . $variable_index . '.default_value') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-2 {{ $errors->has('variables_list.' . $variable_index . '.track_state') ? 'has-error' : '' }}">
        <select name="variables_list[{{ $variable_index }}][track_state]" class="form-control">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
        @if ($errors->has('variables_list.' . $variable_index . '.track_state'))
            <span class="help-block">
                 <strong>{{ $errors->first('variables_list.' . $variable_index . '.track_state') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-1">
        <button data-quest_id="{{ $questId }}" class="btn btn-danger delete_variable" type="button">
            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
        </button>
    </div>
</div>