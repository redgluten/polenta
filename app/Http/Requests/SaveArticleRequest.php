<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveArticleRequest extends Request
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

        $input['chapeau'] = clean($input['chapeau']);
        $input['content'] = clean($input['content']);
        $input['aside1']  = clean($input['aside1']);
        $input['aside2']  = clean($input['aside2']);

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
            'url'          => 'alpha_dash|max:255|unique:articles,url',
            'title'        => 'required|string|max:255',
            'chapeau'      => 'required|string|min:10',
            'content'      => 'required|string|min:25',
            'aside1'       => 'string|min:25',
            'aside2'       => 'string|min:25',
            'issue_id'     => 'required|exists:issues,id',
            'logo'         => 'image|max:25000',
            'logo_caption' => 'string|max:255',
            'user_list'    => 'array',
            'tag_list'     => 'array',
            'draft'        => 'boolean',
        ];

        // Exclude existing model from uniqueness validation on PUT
        if ($this->method() === 'PUT') {
            $rules['url'] .= ',' . $this->route()->parameter('article');
        }

        return $rules;
    }
}
