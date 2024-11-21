<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', Rule::unique('users')->ignore($request->id)],
            'contact_no' => ['required', 'string'],
            'company' => ['required', 'string'],
            'username' => ['required', Rule::unique('users')->ignore($request->id)]
        ];
    }
}
