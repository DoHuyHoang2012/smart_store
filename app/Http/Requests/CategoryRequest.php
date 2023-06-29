<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    private $table = 'category';
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
        $id = $this->id;
        $condName   = "bail|required|unique:$this->table,name";
        if(!empty($id)){
            $condName  .= ",$id";
        }
        return [
            'name'          => $condName,
            'parent_id'          => 'bail|required|not_in:default',
            'status'          => 'bail|in:1,0',
            'orders'          => 'bail|required|not_in:default',
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'Name không được rỗng',
            // 'name.min' => 'Name :input phải có ít nhất :min kí tự',
        ];
    }
    public function attributes()
    {
        return [
             'img' => 'image',
        ];
    }
}
