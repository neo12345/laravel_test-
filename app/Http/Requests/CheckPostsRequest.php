<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CheckPostsRequest extends Request
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
            'title' => 'required|min:5',
            'slug' => 'required|min:5',
            'description' => 'required|must_be_a_b_c_d',
            'content' => 'required'
        ];
    }
    
    public function messages()
    {
        return [
            'description.must_be_a_b_c_d' => '[custom validate] Must be ABCD!',
        ];
    }
}
