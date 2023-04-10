<?php

namespace App\Http\Requests\Proofreadings;

use App\Traits\FailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateProofreading extends FormRequest
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
            'user_id' => 'required',
            'discipline_id' => 'required',
            'group_id' => 'required',
            'hours' => 'required',
            'date' => 'required'
        ];
    }
}
