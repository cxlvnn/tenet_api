<?php

namespace App\Http\Requests;

use App\Shared\Presentation\Response\ValidationResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCompanyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:companies', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'You already have a company with this name',
        ];
    }

    /**
     * Handle failed validation.
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = new ValidationResponse(errors: $validator->errors());

        throw new HttpResponseException(
            response: $response->toResponse(request: $this->request)
        );
    }
}
