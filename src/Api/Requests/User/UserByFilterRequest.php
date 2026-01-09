<?php

namespace Src\Api\Requests\User;

use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\User\GetUserFilterDto;
use Src\Application\Support\DocumentHelper;

class UserByFilterRequest extends BaseRequest
{
    use GetAuthenticatedUser;
    
    public function rules(): array
    {
        $rules = [
            'id' => 'nullable|integer|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'document' => 'nullable|string|max:20',
            'profile_id' => 'nullable|integer|exists:profiles,id',
            'is_active' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
        ];

        $this->normalizeInputs();

        return $rules;
    }

    public function normalizeInputs(): void
    {
        $this->merge([
            'name' => strtolower($this->input('name')),
            'email' => strtolower($this->input('email')),
            'document' => DocumentHelper::stripSpecialChars($this->input('document')),
            'phone' => DocumentHelper::stripSpecialChars($this->input('phone')),
        ]);
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'Página deve ser um número',
            'page_size.integer' => 'Tamanho da página deve ser um número',
        ];
    }

    public function getDto(): GetUserFilterDto
    {
        return new GetUserFilterDto(
            id: $this->input('id'),
            ownerId: $this->getOwnerId(),
            name: $this->input('name'),
            email: $this->input('email'),
            document: $this->input('document'),
            profileId: $this->input('profile_id'),
            isActive: $this->input('is_active'),
            page: $this->input('page', 1),
            pageSize: $this->input('page_size', 10),
        );
    }
}
