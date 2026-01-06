<?php

namespace Src\Api\Requests\Unit;

use DateTime;
use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\Unit\GetUnitFilterDto;

class UnitByFilterRequest extends BaseRequest
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
            'abbreviation' => 'nullable|string',
            'format' => 'nullable|string',
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
            'abbreviation.string' => 'O campo Abreviação deve ser uma string.',
            'format.string' => 'O campo Formato deve ser uma string.',
        ];
    }

    public function getDto(): GetUnitFilterDto
    {
        return new GetUnitFilterDto(
            id: $this->input('id'),
            ownerId: $this->getOwnerId(),
            name: $this->input('name'),
            abbreviation: $this->input('abbreviation'),
            format: $this->input('format'),
            page: $this->input('page', 1),
            pageSize: $this->input('page_size', 10),
        );
    }
}
