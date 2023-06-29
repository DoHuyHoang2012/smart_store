<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    private $table = 'customer';
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
             
        return [
            'email'         => "unique:$this->table,email,$id",
            'fullname'      => 'bail|required|min:5',
            'status'        => 'bail|in:0,1',
            'phone'          => 'bail|required|digits:10',
           
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
