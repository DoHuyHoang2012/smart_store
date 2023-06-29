<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    private $table = 'slider';
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
        $condImg  = 'bail|required|image|max:2000';
        $condName   = "bail|required|between:5,100|unique:$this->table,name";
        if(!empty($id)){
            $condName  .= ",$id";
            $condImg  = 'bail|image|max:2000';
        }
        return [
            'name'          => $condName,
            'link'          => 'bail|required|min:5|url',
            'status'          => 'bail|in:1,0',
            'img'          => $condImg,
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
