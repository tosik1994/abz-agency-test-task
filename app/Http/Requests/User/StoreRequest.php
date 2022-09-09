<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */

    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:60',
            'email' => 'required|min:2|max:100|email|unique:users',
            'phone' => "required|unique:users|regex:'^[\+]{0,1}380([0-9]{9})$'",
            'position_id' => 'required|integer|exists:positions,id|min:1',
            'password' => 'required',
            'photo' => 'required|file|max:5120|mimes:jpeg,jpg'
        ];
    }
}
