<?php

namespace App\Core\Service;

use App\QuestComment;

class QuestCommentService
{
    /**
     * @var WebSocketService
     */
    private $webSocketService;

    public function __construct(WebSocketService $webSocketService)
    {
        $this->webSocketService = $webSocketService;
    }

    public function store($questCommentData)
    {
        $questCommentModel = QuestComment::create($questCommentData);

        $this->webSocketService->connect();
        $this->webSocketService->send('quest_comment_store::' . $questCommentData['quest_id'] . '::' . $questCommentModel->id);

        return $questCommentModel;
    }

    public function update($id, $comment)
    {
        QuestComment::find($id)->update(['comment' => $comment]);

        $this->webSocketService->connect();
        $this->webSocketService->send('quest_comment_update::' . $id);
    }

    public function destroy($id)
    {
        QuestComment::destroy($id);
    }
}