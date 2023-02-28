<?php

namespace App\Http\Requests\Users;

use App\Traits\FailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'filled|email',
            'password' => 'filled',
            'first_name' => 'filled',
            'last_name' => 'filled',
            'surname' => 'filled',
            'birth_day' => 'filled|date',
        ];
    }

    public function messages()
    {
        return [
            'email.filled' => 'Поле "EMAIL" не может быть пустым!',
            'email.email' => 'EMAIL не валиден!',
            'password.filled' => 'Поле "Пароль" не может быть пустым!',
            'first_name.filled' => 'Поле "Имя" не может быть пустым!',
            'last_name.filled' => 'Поле "Фамилия" не может быть пустым!',
            'surname.filled' => 'Поле "Отчество" не может быть пустым!',
            'birth_day.filled' => 'Поле "Дата рождения" не может быть пустым!',
        ];
    }
}
