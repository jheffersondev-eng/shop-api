<?php

namespace Src\Api\Requests\Company;

use Src\Api\Requests\BaseRequest;
use Src\Api\Requests\Traits\GetAuthenticatedUser;
use Src\Application\Dto\Company\CreateCompanyDto;
use Src\Application\Support\DocumentHelper;
use Src\Application\Support\PhoneHelper;

class CreateCompanyRequest extends BaseRequest
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
            'fantasy_name' => 'required|string|max:50',
            'legal_name' => 'required|string|max:100',
            'document' => 'nullable|string|max:20',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:15',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
            'image_banner' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'domain' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'city' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'complement' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:40',
            'is_active' => 'required|boolean',
        ];

        return $rules;
    }

    protected function normalizeInputs(): void
    {
        $this->merge([
            'document' => DocumentHelper::stripSpecialChars($this->input('document')),
            'phone' => PhoneHelper::normalize($this->input('phone')),
            'zip_code' => PhoneHelper::normalize($this->input('zip_code')),
            'is_active' => $this->has('is_active') ? (bool)$this->input('is_active') : true,
        ]);
    }

    public function messages(): array
    {
        return [
            'fantasy_name.required' => 'O nome fantasia é obrigatório.',
            'legal_name.required' => 'O nome legal é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'phone.required' => 'O telefone é obrigatório.',
            'domain.required' => 'O domínio é obrigatório.',
            'document.max' => 'O documento deve ter no máximo 20 caracteres.',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres.',
            'is_active.required' => 'O status de ativo é obrigatório.',
            'is_active.boolean' => 'O status de ativo deve ser verdadeiro ou falso.',
            'neighborhood.required' => 'O bairro é obrigatório.',
            'zip_code.required' => 'O CEP é obrigatório.',
            'state.required' => 'O estado é obrigatório.',
            'city.required' => 'A cidade é obrigatória.',
            'street.required' => 'A rua é obrigatória.',
            'number.required' => 'O número é obrigatório.',
            'image.required' => 'A imagem é obrigatória.',
            'primary_color.required' => 'A cor primária é obrigatória.',
            'secondary_color.required' => 'A cor secundária é obrigatória.',
            'complement.required' => 'Deve ter no maximo 255 caracteres.',
            'slogan.max' => 'O slogan deve ter no máximo 40 caracteres.',
            'image_banner.required' => 'A imagem do banner é obrigatória.',
        ];
    }

    public function getDto(): CreateCompanyDto
    {
        return new CreateCompanyDto(
            ownerId: $this->getOwnerId(),
            fantasyName: $this->input('fantasy_name'),
            legalName: $this->input('legal_name'),
            document: $this->input('document'),
            email: $this->input('email'),
            phone: $this->input('phone'),
            image: $this->file('image'),
            imageBanner: $this->file('image_banner'),
            primaryColor: $this->input('primary_color'),
            secondaryColor: $this->input('secondary_color'),
            neighborhood: $this->input('neighborhood'),
            domain: $this->input('domain'),
            zipCode: $this->input('zip_code'),
            state: $this->input('state'),
            city: $this->input('city'),
            street: $this->input('street'),
            number: $this->input('number'),
            complement: $this->input('complement'),
            description: $this->input('description'),
            slogan: $this->input('slogan'),
            isActive: $this->input('is_active', true),
            userIdCreated: $this->getUserId(),
            userIdUpdated: null,
        );
    }
}
