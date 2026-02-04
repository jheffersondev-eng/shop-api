<?php

namespace Src\Api\Requests\Category;

use Src\Api\Requests\BaseRequest;
use Src\Application\Dto\Category\GetCategoryFilterDto;

class CategoryByFilterPublicRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->normalizeInputs();

        $rules = [
            'id' => 'nullable|integer',
            'name' => 'nullable|string',
            'owner_id' => 'nullable|integer',
            'description' => 'nullable|string',
        ];

        return $rules;
    }

    protected function normalizeInputs(): void
    {
        $this->merge([
            'name' => strtolower($this->input('name')),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O campo Nome deve ser uma string.',
            'id.integer' => 'O campo ID deve ser um número inteiro.',
            'owner_id.integer' => 'O campo Owner ID deve ser um número inteiro.',
            'description.string' => 'O campo Descrição deve ser uma string.',
        ];
    }

    public function getDto(): GetCategoryFilterDto
    {
        return new GetCategoryFilterDto(
            id: $this->input('id'),
            ownerId: $this->input('owner_id'),
            name: $this->input('name'),
            description: $this->input('description'),
            page: $this->input('page', 1),
            pageSize: $this->input('page_size', 10),
        );
    }
}
