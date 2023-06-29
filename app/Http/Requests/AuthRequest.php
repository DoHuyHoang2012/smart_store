<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        $formType = $this->form_type ?? '';
        $condUsername = '';
        $condEmail = '';
        $condFullName = '';
        $condPassword = '';
        $condPhone = '';
        if($formType == 'register'){
            $condUsername = "bail|required|between:6,32|unique:$this->table,username";
            $condEmail = "bail|required|unique:$this->table,email";
            $condFullName = 'bail|required|min:5';
            $condPassword = "bail|required|between:5,100|confirmed";
            $condPhone = 'required|digits:10';
        }else {
            $condUsername = 'bail|required|between:6,100';
            $condPassword = 'bail|required|between:6,100';
        }

        return [
            'username'      =>  $condUsername,
            'email'         => $condEmail,
            'fullname'      =>  $condFullName,
            'password'          => $condPassword,
            'phone'        => $condPhone,
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
