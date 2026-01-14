<?php

namespace Src\Api\Requests\Profile;

use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\Profile\UpdateProfileDto;

class UpdateProfileRequest extends BaseRequest
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
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ];

        return $rules;
    }

    protected function normalizeInputs(): void
    {
        $this->merge([
            'name' => strtolower($this->input('name')),
            'permissions' => json_decode($this->input('permissions')),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O campo Nome deve ser uma string.',
            'permissions.array' => 'O campo Permissões deve ser um array.',
            'description.string' => 'O campo Descrição deve ser uma string.',
        ];
    }

    public function getDto(): UpdateProfileDto
    {
        return new UpdateProfileDto(
            name: $this->input('name'),
            description: $this->input('description'),
            permissions: $this->input('permissions'),
            userIdUpdated: $this->getUserId(),
            ownerId: $this->getOwnerId(),
        );
    }
}
