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
        return [
            'name' => 'required|min:2|max:50|unique:quests,name,' . $this->id,
            'description' => 'required|max:1000',
            'genre' => 'required|valid_genre',
            'user_id' => 'required|integer',
        ];
    }
}
