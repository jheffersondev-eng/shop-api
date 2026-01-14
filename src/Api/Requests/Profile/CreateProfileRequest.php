<?php

namespace Src\Api\Requests\Profile;

use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\Profile\CreateProfileDto;

class CreateProfileRequest extends BaseRequest
{
    use GetAuthenticatedUser;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->normalizeInputs();

        $rules = [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'permissions' => 'required|array',
        ];

        return $rules;
    }

    protected function normalizeInputs(): void
    {
        $this->merge([
            'name' => strtoupper($this->input('name')),
            'permissions' => json_decode($this->input('permissions')),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser um texto.',
            'name.max' => 'O campo Nome deve ter no máximo 50 caracteres.',
            'description.string' => 'O campo Descrição deve ser um texto.',
            'description.max' => 'O campo Descrição deve ter no máximo 255 caracteres.',
            'permissions.required' => 'O campo Permissões é obrigatório.',
            'permissions.string' => 'O campo Permissões deve ser um texto.',
        ];
    }

    public function getDto(): CreateProfileDto
    {
        return new CreateProfileDto(
            name: $this->input('name'),
            description: $this->input('description'),
            permissions: $this->input('permissions'),
            ownerId: $this->getOwnerId(),
            userIdCreated: $this->getUserId(),
            userIdUpdated: null
        );
    }
}
