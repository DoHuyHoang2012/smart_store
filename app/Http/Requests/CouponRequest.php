<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    private $table = 'discount';
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
        
        $condCode   = "bail|required|unique:$this->table,code";
        if(!empty($id)){
            $condCode  .= ",$id";
        }
        return [
            'code'          => $condCode,
            'status'          => 'bail|in:1,0',
            'discount'          => 'required',
            'limit_number'          => 'required',
            'payment_limit'          => 'required',
            'expiration_date'          => 'required',
            'description'          => 'required',
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
