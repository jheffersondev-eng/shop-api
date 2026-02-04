<?php

namespace Src\Api\Requests\Product;

use DateTime;
use Src\Api\Requests\BaseRequest;
use Src\Application\Dto\Product\GetProductFilterDto;

class ProductAllByFilterRequest extends BaseRequest
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
            'owner_id' => 'nullable|integer',
            'name' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'unit_id' => 'nullable|integer',
            'barcode' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'user_id_created' => 'nullable|integer',
            'date_de' => 'nullable|date',
            'date_ate' => 'nullable|date',
        ];

        return $rules;
    }

    protected function normalizeInputs(): void
    {
        $this->merge([
            'name' => strtolower($this->input('name')),
            'date_de' => $this->input('date_de') ? DateTime::createFromFormat('d/m/Y', $this->input('date_de')) : null,
            'date_ate' => $this->input('date_ate') ? DateTime::createFromFormat('d/m/Y', $this->input('date_ate')) : null,
        ]);
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O campo Nome deve ser uma string.',
            'id.integer' => 'O campo ID deve ser um número inteiro.',
            'category_id.integer' => 'O campo Categoria ID deve ser um número inteiro.',
            'unit_id.integer' => 'O campo Unidade ID deve ser um número inteiro.',
            'barcode.string' => 'O campo Código de Barras deve ser uma string.',
            'is_active.boolean' => 'O campo Ativo deve ser verdadeiro ou falso.',
            'user_id_created.integer' => 'O campo User ID Criado deve ser um número inteiro.',
            'date_de.date' => 'O campo Data De deve ser uma data válida.', 
            'date_ate.date' => 'O campo Data Até deve ser uma data válida.',
            'page.integer' => 'O campo Página deve ser um número inteiro.',
            'page.min' => 'O campo Página deve ser maior ou igual a 1.',
            'page_size.integer' => 'O campo Tamanho da Página deve ser um número inteiro.',
            'page_size.min' => 'O campo Tamanho da Página deve ser maior ou igual a 1.',
        ];
    }

    public function getDto(): GetProductFilterDto
    {
        return new GetProductFilterDto(
            id: $this->input('id'),
            ownerId: $this->input('owner_id'),
            name: $this->input('name'),
            categoryId: $this->input('category_id'),
            unitId: $this->input('unit_id'),
            barcode: $this->input('barcode'),
            isActive: $this->input('is_active'),
            userIdCreated: $this->input('user_id_created'),
            dateDe: $this->input('date_de'),
            dateAte: $this->input('date_ate'),
            page: $this->input('page', 1),
            pageSize: $this->input('page_size', 10),
        );
    }
}
