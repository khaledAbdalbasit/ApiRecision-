<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
class AdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if($this->is('api/*')){
            $response = ApiResponse::sendResponse(Response::HTTP_UNPROCESSABLE_ENTITY, 'Validation errors', $validator->errors());
            throw new ValidationException($validator,$response);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'text' => 'required|string',
            'domain_id' => 'required|exists:domains,id',
        ];
    }

    // attributes
    public function attributes():array{
        return [
            'title' => 'Title',
            'phone' => 'Phone',
            'text' => 'text',
            'domain_id' => 'Domain',
        ];
    }
}
