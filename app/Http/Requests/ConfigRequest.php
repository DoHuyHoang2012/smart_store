<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    private $table = 'user';
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
            'mail_smtp'          => 'bail|required|email',
            'mail_smtp_password'          => 'required',
            'mail_from_name'          => 'required',
            'priceShip'          => 'required',
            'title'          => 'required',
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
            // 'description' => 'Description Field: ',
        ];
    }
}
