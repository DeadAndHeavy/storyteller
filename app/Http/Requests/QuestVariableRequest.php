<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class QuestVariableRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'quest_id' => 'required|integer',
            'default_value' => 'required',
            'type' => 'required|valid_quest_variable_type',
            'track_state' => 'required'
        ];
    }
}
