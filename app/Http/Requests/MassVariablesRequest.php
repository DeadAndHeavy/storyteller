<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MassVariablesRequest extends Request
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
            'variables_list.*.title.required' => 'Variable title required',
            'variables_list.*.default_value.required' => 'Variable default value required',
            'variables_list.*.type.required' => 'Variable type required',
            'variables_list.*.track_state.required' => 'Track state required',
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
            'variables_list.*.title' => 'required',
            'variables_list.*.quest_id' => 'required|integer',
            'variables_list.*.default_value' => 'required',
            'variables_list.*.type' => 'required|valid_quest_variable_type',
            'variables_list.*.track_state' => 'required'
        ];
    }
}
