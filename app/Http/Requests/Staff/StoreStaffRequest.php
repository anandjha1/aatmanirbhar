<?php

namespace App\Http\Requests\Staff;

use App\Enums\StaffRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:staff,email'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', Rule::enum(StaffRole::class)],
            'phone' => ['nullable', 'string', 'max:15'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
