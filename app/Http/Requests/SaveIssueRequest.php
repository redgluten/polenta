<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveIssueRequest extends Request
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

    public function sanitize() : array
    {
        $input = $this->all();

        $input['masthead']          = clean($input['masthead']);
        $input['editorial_content'] = clean($input['editorial_content']);

        $this->replace($input);

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'number'            => 'required|numeric|unique:issues,number',
            'presentation'      => 'string|max:4000',
            'masthead'          => 'string',
            'cover'             => 'image|max:8000',
            'print_file'        => 'mimes:pdf|max:50000',
            'published_at'      => 'required|date_format:d/m/Y',
            'editorial_title'   => 'string|max:255',
            'editorial_content' => 'string',
        ];

        // Exclude existing model from uniqueness validation on PUT
        if (in_array($this->method, ['PUT', 'PATCH'])) {
            $rules['number'] .= ',' . $this->route()->parameter('issue');
        }

        return $rules;
    }
}
