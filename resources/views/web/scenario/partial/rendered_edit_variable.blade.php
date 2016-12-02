<tr>
    <form class="form-horizontal" role="form" method="POST" action="{{ route('update_quest_variable', ['questId' => $variable->questId, 'variableId' => $variable->id]) }}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <input name="quest_id" type="hidden" value="{{ $variable->questId }}">
        <td class="text-center vertical-align">
            <input name="title" type="text" class="form-control" value="{{ $variable->title }}" placeholder="Enter variable title...">
        </td>
        <td class="text-center vertical-align">
            <select name="type" class="form-control">
                @foreach ($variableTypes as $key => $value)
                    @if ($variable->type == $key)
                        <option selected value="{{ $key }}">{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @endforeach
            </select>
        </td>
        <td class="text-center vertical-align">
            <input name="default_value" type="text" class="form-control" value="{{ $variable->default_value }}" placeholder="Enter default value...">
        </td>
        <td class="text-center vertical-align">
            <select name="track_state" class="form-control">
                <option {{ $variable->track_state == 0 ? 'selected' : '' }} value="0">No</option>
                <option {{ $variable->track_state == 1 ? 'selected' : '' }} value="1">Yes</option>
            </select>
        </td>
    </form>

    <td class="text-center vertical-align">
        <button type="button" data-variable_id="{{ $variable->id }}" class="btn btn-primary update_quest_variable" title="Update variable">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </button>
        <form class="delete_variable" style="display:inline" role="form" action="{{ route('delete_quest_variable', ['questId' => $variable->quest_id, 'variableId' => $variable->id]) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure you want to delete this variable?');" type="submit" class="btn btn-danger" title="Delete variable">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </form>
    </td>
</tr>