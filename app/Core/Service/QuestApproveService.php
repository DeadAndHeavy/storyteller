<?php

namespace App\Core\Service;

use App\QuestApproveQueue;

class QuestApproveService
{
    const QUEST_APPROVE_STATUS_NOT_APPROVED = 0;
    const QUEST_APPROVE_STATUS_REJECTED = 1;
    const QUEST_APPROVE_STATUS_APPROVED = 2;

    public static function getApproveStatusList()
    {
        return [
            self::QUEST_APPROVE_STATUS_NOT_APPROVED => trans('quest.approve_status_' . self::QUEST_APPROVE_STATUS_NOT_APPROVED),
            self::QUEST_APPROVE_STATUS_REJECTED => trans('quest.approve_status_' . self::QUEST_APPROVE_STATUS_REJECTED),
            self::QUEST_APPROVE_STATUS_APPROVED => trans('quest.approve_status_' . self::QUEST_APPROVE_STATUS_APPROVED),
        ];
    }

    public function sendForApprove($questId)
    {
        $questForApproving = QuestApproveQueue::where('quest_id', $questId)->first();
        if (!$questForApproving) {
            QuestApproveQueue::create(['quest_id' => $questId]);
        } else {
            $questForApproving->update(['message' => '', 'approve_status' => self::QUEST_APPROVE_STATUS_NOT_APPROVED]);
        }
    }

    public function getNotApproved()
    {
        return QuestApproveQueue::where('approve_status', self::QUEST_APPROVE_STATUS_NOT_APPROVED)->get();
    }

    public static function getNotApprovedForBadge()
    {
        return QuestApproveQueue::where('approve_status', self::QUEST_APPROVE_STATUS_NOT_APPROVED)->get()->count();
    }

    public function approve($questId)
    {
        QuestApproveQueue::where('quest_id', $questId)->update([
            'approve_status' => self::QUEST_APPROVE_STATUS_APPROVED,
            'message' => ''
        ]);
    }

    public function reject($questId, $rejectData)
    {
        QuestApproveQueue::where('quest_id', $questId)->update($rejectData);
    }
}