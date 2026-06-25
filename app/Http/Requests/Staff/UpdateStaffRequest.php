<?php

namespace App\Http\Requests\Staff;

use App\Enums\StaffRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('staff', 'email')->ignore($this->route('staff'))],
            'password' => ['sometimes', Password::defaults()],
            'role' => ['sometimes', Rule::enum(StaffRole::class)],
            'phone' => ['nullable', 'string', 'max:15'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
