<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // You can add role/permission checks here later
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $permission = $this->route('permission');
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_-]+$/', // Only lowercase letters, numbers, underscores, and hyphens
                Rule::unique('permissions', 'name')->ignore($permission->id ?? null),
            ],
            'guard_name' => 'nullable|string|max:255|in:web,api',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Permission name is required.',
            'name.unique' => 'This permission name already exists.',
            'name.regex' => 'Permission name must contain only lowercase letters, numbers, underscores, and hyphens.',
            'guard_name.in' => 'Guard name must be either web or api.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'permission name',
            'guard_name' => 'guard name',
        ];
    }
}
