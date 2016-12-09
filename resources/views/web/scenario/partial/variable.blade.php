<tr class="variable_row">
    <td class="text-center vertical-align">{{ $variable->title }}</td>
    <td class="text-center vertical-align">{{ $variable->type }}</td>
    <td class="text-center vertical-align">{{ $variable->default_value }}</td>
    <td class="text-center vertical-align">{{ $variable->track_state ? 'Yes' : 'No'}}</td>
    <td class="text-center vertical-align">
        <a href="{{ route('edit_quest_variable', ['questId' => $variable->quest_id, 'variableId' => $variable->id]) }}" class="btn btn-primary edit_quest_variable" title="Edit variable">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <form class="delete_variable" style="display:inline" role="form" action="{{ route('delete_quest_variable', ['questId' => $variable->quest_id, 'variableId' => $variable->id]) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure you want to delete this variable?');" type="submit" class="btn btn-danger" title="Delete variable">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </form>
    </td>
</tr>

