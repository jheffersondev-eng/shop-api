<?php

namespace Src\Api\Requests\Unit;

use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\Unit\CreateUnitDto;

class CreateUnitRequest extends BaseRequest
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
            'abbreviation' => 'required|string',
            'format' => 'required|integer',
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
            'name.string' => 'O campo Nome deve ser uma string.',
            'abbreviation.string' => 'O campo Abreviação deve ser uma string.',
            'format.integer' => 'O campo Formato deve ser um número inteiro.',
        ];
    }

    public function getDto(): CreateUnitDto
    {
        return new CreateUnitDto(
            name: $this->input('name'),
            abbreviation: $this->input('abbreviation'),
            format: $this->input('format'),
            ownerId: $this->getOwnerId(),
            userIdCreated: $this->getUserId(),
            userIdUpdated: null
        );
    }
}
