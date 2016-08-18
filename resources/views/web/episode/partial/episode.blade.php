<tr>
    <td class="vertical-align">{{ $episode->title }}</td>
    <td class="text-center vertical-align">{{ $episode->type }}</td>
    <td class="text-center vertical-align">{{ count($episode->episodeActions) }}</td>
    <td class="text-center vertical-align">
        <a href="{{ route('edit_episode', ['questId' => $episode->quest->id, 'episodeId' => $episode->id]) }}" class="btn btn-primary" title="Update episode">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <form class="delete_episode" style="display:inline" role="form" action="{{ route('delete_episode', ['questId' => $episode->quest->id, 'episodeId' => $episode->id]) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure you want to delete this episode?');" type="submit" class="btn btn-danger" title="Delete episode">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </form>
    </td>
</tr>

