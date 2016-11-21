<tr>
    <td class="text-center vertical-align">
        <a href="{{ route('quest_page', ['questId' => $quest->id]) }}">{{ $quest->name }}</a>
    </td>
    <td class="vertical-align">{{ str_limit(ltrim(strip_tags($quest->description), "&nbsp; "), $limit = 220, $end = '...') }}</td>
    <td class="text-center vertical-align">@lang('quest.genre_' . $quest->genre)</td>
    <td class="text-center vertical-align">
        <a href="{{ route('edit_quest', ['questId' => $quest->id]) }}" class="btn btn-primary" title="Update quest info">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <a href="{{ route('all_episodes', ['questId' => $quest->id]) }}" class="btn btn-success" title="Manage quest episodes">
            <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
        </a>
        <a href="{{ route('scenario', ['questId' => $quest->id]) }}" class="btn btn-epic" title="Quest scenario">
            <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
        </a>
        <a href="{{ route('play_quest', ['questId' => $quest->id]) }}" class="btn btn-info" title="Play quest">
            <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
        </a>
        <form class="delete_quest" style="display:inline" role="form" action="{{ route('delete_quest', ['questId' => $quest->id]) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure you want to delete this quest?');" type="submit" class="btn btn-danger" title="Delete quest">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </form>
    </td>
</tr>