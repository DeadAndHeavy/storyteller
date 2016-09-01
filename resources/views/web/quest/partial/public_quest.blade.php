<tr class="quest_row">
    <td class="text-center vertical-align">
        <a href="{{ route('quest_page', ['questId' => $quest->id]) }}">{{ $quest->name }}</a>
    </td>
    <td class="vertical-align">{{ str_limit($quest->description, $limit = 220, $end = '...') }}</td>
    <td class="text-center vertical-align">@lang('quest.genre_' . $quest->genre)</td>
    <td class="text-center vertical-align">{{ $quest->author->name }}</td>
    <td class="text-center vertical-align">
        <h4><span class="rating_counter">{{ $quest->votes->pluck('type')->sum() }}</span></h4>
    </td>
    <td class="text-center vertical-align">
        <h4><span class="comments_counter">{{ $quest->comments->count() }}</span></h4>
    </td>
    @if (Auth::check())
        <td class="text-center vertical-align">
            <button type="button" class="btn btn-success like_quest {{ (\App\Core\Service\VoteService::alreadyVoted($quest->id) && \App\Core\Service\VoteService::alreadyVoted($quest->id)->type == \App\Core\Service\VoteService::VOTE_TYPE_LIKE) ? 'opacity-05' : '' }}" data-route="{{ route('like_quest', ['questId' => $quest->id]) }}" title="Like quest">
                <span class="glyphicon {{ (\App\Core\Service\VoteService::alreadyVoted($quest->id) && \App\Core\Service\VoteService::alreadyVoted($quest->id)->type == \App\Core\Service\VoteService::VOTE_TYPE_LIKE) ? 'glyphicon-ok' : 'glyphicon-thumbs-up' }}" aria-hidden="true"></span>
            </button>
            <button type="submit" class="btn btn-danger dislike_quest {{ (\App\Core\Service\VoteService::alreadyVoted($quest->id) && \App\Core\Service\VoteService::alreadyVoted($quest->id)->type == \App\Core\Service\VoteService::VOTE_TYPE_DISLIKE) ? 'opacity-05' : '' }}" data-route="{{ route('dislike_quest', ['questId' => $quest->id]) }}" title="Dislike quest">
                <span class="glyphicon {{ (\App\Core\Service\VoteService::alreadyVoted($quest->id) && \App\Core\Service\VoteService::alreadyVoted($quest->id)->type == \App\Core\Service\VoteService::VOTE_TYPE_DISLIKE) ? 'glyphicon-ok' : 'glyphicon-thumbs-down' }}" aria-hidden="true"></span>
            </button>
            <a href="{{ route('play_quest', ['questId' => $quest->id]) }}" class="btn btn-info" title="Play quest">
                <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
            </a>
            @if (Auth::check() && Auth::user()->isAdmin())
                <button type="button" class="btn btn-warning" data-reject_route="{{ route('reject_quest', ['questId' => $quest->id]) }}" data-toggle="modal" data-target="#rejectQuestModal">
                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                </button>
            @endif
        </td>
    @endif
</tr>