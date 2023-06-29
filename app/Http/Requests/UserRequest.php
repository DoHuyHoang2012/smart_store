<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->id;
        $task = $this->task;
        $condUsername   = '';
        $condEmail      = '';
        $condFullname   = '';
        $condPass       = '';
        $condImg     = '';
        $condGender     = '';
        $condRole       = '';
        $condStatus     = '';
        switch($task){
            case 'add':
                $condImg     = 'bail|image|max:2000';
                $condUsername   = "bail|required|between:5,100|unique:$this->table,username";
                $condFullname   = 'bail|required|min:5';
                $condEmail      = "bail|required|email|unique:$this->table,email";
                $condPass       = "bail|required|between:5,100|confirmed";
                $condGender     = 'bail|in:0,1';
                $condRole       = 'bail|in:admin,staff';
                $condStatus     = 'bail|in:0,1';
                break;
            case 'edit-info':
                $condImg     = 'bail|image|max:2000';
                $condUsername   = "bail|required|between:5,100|unique:$this->table,username,$id";
                $condEmail      = "bail|required|email|unique:$this->table,email,$id";
                $condStatus     = 'bail|in:0,1';
                $condGender     = 'bail|in:0,1';
                $condFullname   = 'bail|required|min:5';
                break;
            case 'change-password':
                $condPass       = "bail|required|between:5,100|confirmed";
                break;
            case 'change-level':
                $condRole      = 'bail|in:admin,staff';
                break;
            default:
                break;
        }
        return [
            'username'      => $condUsername,
            'email'         => $condEmail,
            'fullname'      => $condFullname,
            'status'        => $condStatus,
            'role'          => $condRole,
            'gender'        => $condGender,
            'img'        => $condImg,
            'password'      => $condPass,
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
