<?php

namespace App\Core\Service;

use App\QuestComment;

class QuestCommentService
{
    public function store($questCommentData)
    {
        QuestComment::create($questCommentData);
    }

    public function update($id, $comment)
    {
        QuestComment::find($id)->update(['comment' => $comment]);
    }

    public function destroy($id)
    {
        QuestComment::destroy($id);
    }
}