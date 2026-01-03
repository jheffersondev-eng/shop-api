<?php

namespace Src\Api\Requests\Auth;

use Src\Api\Requests\BaseRequest;
use Src\Application\Dto\Login\AuthDto;

class AuthRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->normalizeInputs();

        $rules = [
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ];

        return $rules;
    }

    protected function normalizeInputs(): void
    {
        $this->merge([
            'email' => strtolower($this->input('email')),
        ]);
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo Email é obrigatório.',
            'email.email' => 'O campo Email deve ser um endereço de email válido.',

            'password.required' => 'O campo Senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        ];
    }

    public function getDto(): AuthDto
    {
        return new AuthDto(
            $this->input('email'),
            $this->input('password'),
        );
    }
}
