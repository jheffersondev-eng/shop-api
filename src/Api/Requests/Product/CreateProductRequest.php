<?php

namespace Src\Api\Requests\Product;

use Src\Api\Requests\BaseRequest;
use Src\Application\Dto\Product\CreateProductDto;

class CreateProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->normalizeInputs();

        $rules = [
            'owner_id' => 'required|integer',
            'name' => 'required|string',
            'images' => 'required|array',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'barcode' => 'required|string',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'stock_quantity' => 'required|numeric',
            'min_quantity' => 'required|numeric',
            'user_id_created' => 'required|integer',
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
            'images.array' => 'O campo Imagens deve ser um array.',
            'description.string' => 'O campo Descrição deve ser uma string.',
            'owner_id.integer' => 'O campo Owner ID deve ser um número inteiro.',
            'category_id.integer' => 'O campo Categoria ID deve ser um número inteiro.',
            'unit_id.integer' => 'O campo Unidade ID deve ser um número inteiro.',
            'barcode.string' => 'O campo Código de Barras deve ser uma string.',
            'is_active.boolean' => 'O campo Ativo deve ser verdadeiro ou falso.',
            'price.numeric' => 'O campo Preço deve ser um número.',
            'price.min' => 'O campo Preço deve ser maior ou igual a 0.',
            'cost_price.numeric' => 'O campo Preço de Custo deve ser um número.',
            'cost_price.min' => 'O campo Preço de Custo deve ser maior ou igual a 0.',
            'stock_quantity.numeric' => 'O campo Quantidade em Estoque deve ser um número.',
            'stock_quantity.min' => 'O campo Quantidade em Estoque deve ser maior ou igual a 0.',
            'min_quantity.numeric' => 'O campo Quantidade Mínima deve ser um número.',
            'min_quantity.min' => 'O campo Quantidade Mínima deve ser maior ou igual a 0.',
            'user_id_created.integer' => 'O campo User ID Criado deve ser um número inteiro.',
        ];
    }

    public function getDto(): CreateProductDto
    {
        return new CreateProductDto(
            name: $this->input('name'),
            images: $this->input('images'),
            description: $this->input('description'),
            ownerId: $this->input('owner_id'),
            categoryId: $this->input('category_id'),
            unitId: $this->input('unit_id'),
            barcode: $this->input('barcode'),
            isActive: $this->input('is_active'),
            price: $this->input('price'),
            costPrice: $this->input('cost_price'),
            stockQuantity: $this->input('stock_quantity'),
            minQuantity: $this->input('min_quantity'),
            userIdCreated: $this->input('user_id_created'),
        );
    }
}
