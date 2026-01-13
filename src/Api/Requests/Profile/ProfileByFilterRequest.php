<?php

namespace Src\Api\Requests\Profile;

use DateTime;
use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\Profile\GetProfileFilterDto;

class ProfileByFilterRequest extends BaseRequest
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
            'id' => 'nullable|integer',
            'name' => 'nullable|string',
            'permissions' => 'nullable|array',
            'owner_id' => 'nullable|integer',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1',
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
            'permissions.array' => 'O campo Permissões deve ser um array.',
            'owner_id.integer' => 'O campo ID do Proprietário deve ser um número inteiro.',
            'date_de.date' => 'O campo Data De deve ser uma data válida.', 
            'date_ate.date' => 'O campo Data Até deve ser uma data válida.',
            'page.integer' => 'O campo Página deve ser um número inteiro.',
            'page.min' => 'O campo Página deve ser maior ou igual a 1.',
            'page_size.integer' => 'O campo Tamanho da Página deve ser um número inteiro.',
            'page_size.min' => 'O campo Tamanho da Página deve ser maior ou igual a 1.',
        ];
    }

    public function getDto(): GetProfileFilterDto
    {
        return new GetProfileFilterDto(
            id: $this->input('id'),
            ownerId: $this->getOwnerId(),
            name: $this->input('name'),
            permissions: $this->input('permissions'),
            page: $this->input('page', 1),
            pageSize: $this->input('page_size', 10),
        );
    }
}
