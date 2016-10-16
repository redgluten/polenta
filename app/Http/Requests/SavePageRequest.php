<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SavePageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Sanitize inputs before validation
     */
    public function sanitize() : array
    {
        $input = $this->all();

        $input['content'] = clean($input['content']);

        $this->replace($input);

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        $rules = [
            'title'                     => 'required|string|max:255|unique:pages,title',
            'url'                       => 'alpha_dash|max:255',
            'content'                   => 'required',
            'display_in_menu'           => 'boolean',
            'display_in_footer'         => 'boolean',
        ];

        // Exclude existing model from uniqueness validation on PUT
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules ['title'] .= ',' . $this->route()->parameters()['page'];;
            $rules ['url']   .= '|unique:pages,url,' . $this->route()->parameters()['page'];;
        }

        return $rules;
    }
}
