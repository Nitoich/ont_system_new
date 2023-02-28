<?php

namespace App\Http\Requests\Users;

use App\Traits\FailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddRolesRequest extends FormRequest
{
    use FailedValidationRequest;
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
            'roles_ids' => 'required|array'
        ];
    }
}
