<tr>
    <td class="text-center vertical-align">{{ $quest->name }}</td>
    <td class="vertical-align">{{ $quest->description }}</td>
    <td class="text-center vertical-align">@lang('quest.genre_' . $quest->genre)</td>
    <td class="text-center vertical-align">
        <a href="{{ route('edit_quest', ['id' => $quest->id]) }}" class="btn btn-primary" title="Update quest info">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <a href="{{ route('all_episodes', ['id' => $quest->id]) }}" class="btn btn-success" title="Manage quest episodes">
            <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
        </a>
        <a href="{{ route('scenario', ['id' => $quest->id]) }}" class="btn btn-epic" title="Quest scenario">
            <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
        </a>
        <form class="delete_quest" style="display:inline" role="form" action="{{ route('delete_quest', ['id' => $quest->id]) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure you want to delete this quest?');" type="submit" class="btn btn-danger" title="Delete quest">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </form>
    </td>
</tr>