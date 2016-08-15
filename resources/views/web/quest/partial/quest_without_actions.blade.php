<tr>
    <td class="text-center vertical-align">{{ $quest->name }}</td>
    <td class="vertical-align">{{ $quest->description }}</td>
    <td class="text-center vertical-align">@lang('quest.genre_' . $quest->genre)</td>
    <td class="text-center vertical-align">{{ $quest->author->name }}</td>
</tr>