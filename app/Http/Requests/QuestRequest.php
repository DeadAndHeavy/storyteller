<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class QuestRequest extends Request
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
        $imageRules = $this->questId ? 'mimes:jpeg,png' : 'required|mimes:jpeg,png';

        return [
            'name' => 'required|min:2|max:50|unique:quests,name,' . $this->questId,
            'description' => 'required|max:3000',
            'genre' => 'required|valid_genre',
            'quest_image' => $imageRules,
            'user_id' => 'required|integer',
        ];
    }
}
