<?php

namespace App\Http\Admin\Requests\AdminUserRequest;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_id' => 'sometimes|required|integer|exists:admin_role,role_id',
            'name' => 'required|string',
            'description' => 'sometimes|required|string',
            'sort' => 'required|integer',
        ];
    }
}
