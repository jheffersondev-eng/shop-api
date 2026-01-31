<?php

namespace Src\Application\Mappers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Application\Reponses\Company\GetCompanyByFilterResponseDto;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class CompaniesMapper
{
    public function map(Collection $companiesEntity): array
    {
        return $companiesEntity->map(function ($company) {
            $userUpdated = $company->user_updated_id ? new UserDetailSummaryResponseDto(
                id: $company->user_updated_id,
                name: $company->user_updated_name
            ) : null;

            $userCreated = $company->user_created_id ? new UserDetailSummaryResponseDto(
                id: $company->user_created_id,
                name: $company->user_created_name
            ) : null;

            $userDeleted = $company->user_deleted_id ? new UserDetailSummaryResponseDto(
                id: $company->user_deleted_id,
                name: $company->user_deleted_name
            ) : null;

            return new GetCompanyByFilterResponseDto(
                id: $company->id,
                owner: new UserDetailSummaryResponseDto(
                    id: $company->owner_id,
                    name: $company->owner_name
                ),
                fantasyName: $company->fantasy_name,
                legalName: $company->legal_name,
                document: $company->document,
                email: $company->email,
                phone: $company->phone,
                primaryColor: $company->primary_color,
                secondaryColor: $company->secondary_color,
                domain: $company->domain,
                zipCode: $company->zip_code,
                state: $company->state,
                city: $company->city,
                neighborhood: $company->neighborhood,
                street: $company->street,
                number: $company->number,
                complement: $company->complement,
                isActive: $company->is_active,
                image: $company->image,
                description: $company->description,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                userDeleted: $userDeleted,
                createdAt: Carbon::parse($company->created_at)->subHours(3),
                updatedAt: $company->updated_at ? Carbon::parse($company->updated_at)->subHours(3) : null,
                deletedAt: $company->deleted_at ? Carbon::parse($company->deleted_at)->subHours(3) : null
            );
        })->toArray();
    }
}
