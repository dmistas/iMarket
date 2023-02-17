<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email:dns'],
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }
}
