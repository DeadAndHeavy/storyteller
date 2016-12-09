<?php

namespace App\Core\Service;

use App\QuestVariable;

class QuestLogicService
{
    const VARIABLE_TYPE_ITEM = 'item';
    const VARIABLE_TYPE_PROPERTY = 'property';

    /**
     * Get all episode types (start, normal, finish)
     *
     * @return array
     */
    public static function getAllVariableTypes()
    {
        return [
            self::VARIABLE_TYPE_ITEM => trans('variable.type_' . self::VARIABLE_TYPE_ITEM),
            self::VARIABLE_TYPE_PROPERTY => trans('variable.type_' . self::VARIABLE_TYPE_PROPERTY),
        ];
    }

    public function storeVariable($variableData)
    {
        QuestVariable::create($variableData);
    }

    public function saveVariables($variablesDataList)
    {
        if (count($variablesDataList)) {
            foreach($variablesDataList as $variableData) {
                (new QuestVariable($variableData))->save();
            }
        }
    }

    public function updateVariable($variableId, $variableData)
    {
        QuestVariable::find($variableId)->update($variableData);
    }

    public function destroyVariable($variableId)
    {
        QuestVariable::destroy($variableId);
    }

    public function getQuestVariables($questId)
    {
        return QuestVariable::where('quest_id', $questId)->get();
    }
}