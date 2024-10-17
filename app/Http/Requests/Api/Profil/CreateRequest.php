<?php

namespace App\Http\Requests\Api\Profil;

use App\Enums\StatusProfil;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom'       => ['required', 'string', 'string'],
            'prenom'    => ['required', 'string', 'max:255'],
            'image'     => ['required', 'image', 'mimes:jpeg,jpg,png'],
            'status'    => ['required', Rule::enum(StatusProfil::class)],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error validation',
            'errorslist' => [
                $validator->errors(),
            ]
        ], Response::HTTP_BAD_REQUEST));
    }
}
