<?php

namespace App\Http\Requests;

use App\Core\Service\EpisodeService;
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
        return true;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'actions_list.*.content.required' => 'Episode action content required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $imageRules = $this->episode_id ? 'mimes:jpeg,png' : 'required|mimes:jpeg,png';

        return [
            'title' => 'required',
            'quest_id' => 'required|integer',
            'content' => 'required|max:' . EpisodeService::EPISODE_MAX_LENGTH,
            'type' => 'required|valid_episode_type|unique_episode_type:' . $this->type . ',' . $this->quest_id . ',' . $this->episode_id,
            'episode_image' => $imageRules,
            'actions_list.*.content' => 'required',
            'actions_list' => 'actions_limit:10'
        ];
    }
}
