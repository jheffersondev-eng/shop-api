<?php

namespace Src\Api\Requests\User;

use Src\Api\Requests\BaseRequest;
use Src\Application\Dto\User\VerifyEmailDto;

class VerifyUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'user_id' => ['required', 'integer'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'verification_code' => ['required', 'string', 'max:6'],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo ID do usuário é obrigatório.',
            'user_id.integer' => 'O campo ID do usuário deve ser um número inteiro.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O campo E-mail deve ter no máximo 200 caracteres.',
            'verification_code.required' => 'O campo Código de Verificação é obrigatório.',
            'verification_code.string' => 'O campo Código de Verificação deve ser um texto.',
            'verification_code.max' => 'O campo Código de Verificação deve ter no máximo 200 caracteres.',
        ];
    }

    public function getDto(): VerifyEmailDto
    {
        return new VerifyEmailDto(
            userId: $this->input('user_id'),
            email: $this->input('email'),
            verificationCode: $this->input('verification_code'),
        );
    }
}
