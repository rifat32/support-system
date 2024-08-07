<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateProfileRequest extends BaseFormRequest
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
        return [

            'first_Name' => 'required|string|max:255',
            'middle_Name' => 'nullable|string|max:255',
            'last_Name' => 'required|string|max:255',
            // 'email' => 'required|string|email|indisposable|max:255|unique:users',
            'email' => 'required|string|unique:users,email,' . auth()->user()->id . ',id',

            'password' => 'nullable|confirmed|string|min:6',
            'phone' => 'required|string',
            'image' => 'nullable|string',
            'address_line_1' => 'nullable',
            'address_line_2' => 'nullable',
            'country' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'nullable|string',
            'lat' => 'nullable|string',
            'long' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female,other',
            'emergency_contact_details' => "nullable|array"

        ];
    }
    public function messages()
    {
        return [
            'gender.in' => 'The :attribute field must be in "male","female","other".',
        ];
    }
}
