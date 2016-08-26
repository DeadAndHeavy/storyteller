<tr>
    <td class="text-center vertical-align">
        <a href="{{ route('quest_page', ['questId' => $quest->id]) }}">{{ $quest->name }}</a>
    </td>
    <td class="vertical-align">{{ str_limit($quest->description, $limit = 220, $end = '...') }}</td>
    <td class="text-center vertical-align">@lang('quest.genre_' . $quest->genre)</td>
    <td class="text-center vertical-align">{{ $quest->author->name }}</td>
</tr>