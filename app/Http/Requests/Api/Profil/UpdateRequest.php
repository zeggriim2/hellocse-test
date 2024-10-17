<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Profil;

use App\Enums\StatusProfil;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateRequest extends FormRequest
{
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
            'nom'       => 'string|max:255',
            'prenom'    => 'string|max:255',
            'status'    => [Rule::enum(StatusProfil::class)],
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
