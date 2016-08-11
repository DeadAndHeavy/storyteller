<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EpisodeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'episodes.*.content.required' => 'Episode content is required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quest_id' => 'required|integer',
            'episode_number' => 'required|integer'
        ];
    }
}
