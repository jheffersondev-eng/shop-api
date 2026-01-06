<?php

namespace Src\Api\Requests\Category;

use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\Category\CreateCategoryDto;

class UpdateCategoryRequest extends BaseRequest
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
            'name' => 'required|string',
            'description' => 'required|string',
        ];

        return $rules;
    }

    protected function normalizeInputs(): void
    {
        $this->merge([
            'name' => strtoupper($this->input('name')),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser uma string.',
            'description.required' => 'O campo Descrição é obrigatório.',
            'description.string' => 'O campo Descrição deve ser uma string.',
        ];
    }

    public function getDto(): CreateCategoryDto
    {
        return new CreateCategoryDto(
            name: $this->input('name'),
            description: $this->input('description'),
            ownerId: $this->getOwnerId(),
            userIdCreated: null,
            userIdUpdated: $this->getUserId()
        );
    }
}
