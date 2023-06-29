<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    private $table = 'product';
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
        $condImg  = 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $condAvatar = 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $condImages = 'required';
        if(!empty($id)){
            $condName  .= ",$id";
            $condAvatar  = 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $condImages  = '';
        }
        return [
            'name'          => $condName,
            'status'          => 'bail|in:1,0',
            'cat_id'          => 'required',
            'producer_id'          => 'required',
            'avatar'          => $condAvatar,
            'images'             => $condImages,
            'images.*'          => $condImg,
            'detail'            => 'required'
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
            
        ];
    }
}
