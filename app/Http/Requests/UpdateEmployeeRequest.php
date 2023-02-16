<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('employee');
        return [
             'fname'=>['required'],
            'lname'=>['required'],
            'company'=>['required',Rule::exists('companies','id')],
            'email'=>['required','email',Rule::unique('employees','email')->ignore($id)],
            'phone'=>['required','min:9','max:11']
        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'Please filled your first name',
            'lname.required' =>'Please filled your last name',
        ];
    }
}
