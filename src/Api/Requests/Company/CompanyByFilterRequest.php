<?php

namespace Src\Api\Requests\Company;

use Src\Api\Requests\BaseRequest;
use Src\Application\Dto\Company\GetCompanyFilterDto;

class CompanyByFilterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->normalizeInputs();

        $rules = [
            'id' => 'nullable|string',
            'name' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
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
            'id.string' => 'O campo ID deve ser uma string.',
        ];
    }

    public function getDto(): GetCompanyFilterDto
    {
        return new GetCompanyFilterDto(
            id: $this->input('id'),
            name: $this->input('name'),
            page: $this->input('page', 1),
            pageSize: $this->input('page_size', 10),
        );
    }
}
