<?php

namespace App\Core\Service;

use App\Vote;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    const VOTE_TYPE_LIKE = 1;
    const VOTE_TYPE_DISLIKE = -1;

    public function store($questId, $userId, $type)
    {
        $alreadyVoted = Vote::where('quest_id', $questId)->where('user_id', $userId)->first();
        if ($alreadyVoted) {
            $alreadyVoted->delete();
        }
        $voteData = [
            'quest_id' => $questId,
            'user_id' => $userId,
            'type' => $type
        ];
        Vote::create($voteData);
    }

    public static function alreadyVoted($questId)
    {
        return Vote::where('quest_id', $questId)->where('user_id', Auth::user()->id)->first();
    }

    public function getVotes($questId)
    {
        return Vote::where('quest_id', $questId)->get()->count();
    }

    public function getLikesCount($questId)
    {
        return Vote::where('quest_id', $questId)->where('type', self::VOTE_TYPE_LIKE)->get()->count();
    }

    public function getDislikesCount($questId)
    {
        return Vote::where('quest_id', $questId)->where('type', self::VOTE_TYPE_DISLIKE)->get()->count();
    }
}