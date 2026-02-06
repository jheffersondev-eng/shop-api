<?php

namespace Src\Infrastructure\Persistence\Repositories;

use COM;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Src\Application\Dto\Company\GetCompanyFilterDto;
use Src\Application\Interfaces\Repositories\ICompanyRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Src\Application\Dto\Company\CreateCompanyDto;
use Src\Application\Exceptions\CompanyNotFoundException;
use Src\Application\Mappers\GenericMapper;
use Src\Application\Mappers\CompaniesMapper;
use Src\Domain\Entities\CompanyEntity;
use Src\Infrastructure\Persistence\Models\Company;

class CompanyRepository implements ICompanyRepository
{
    private CompaniesMapper $mapper;

    public function __construct()
    {
        $this->mapper = new CompaniesMapper();
    }

    public function getCompaniesByFilter(GetCompanyFilterDto $getCompanyFilterDto): array
    {
        try {
            $query = DB::table('companies as c')
            ->leftJoin('user_details as cdo', 'c.owner_id', '=', 'cdo.id')
            ->leftJoin('user_details as cdc', 'c.user_id_created', '=', 'cdc.id')
            ->leftJoin('user_details as cdu', 'c.user_id_updated', '=', 'cdu.id')
            ->leftJoin('user_details as cdd', 'c.user_id_deleted', '=', 'cdd.id')
            ->select(
                'c.id',
                'c.owner_id',
                'c.fantasy_name',
                'c.description',
                'c.slogan',
                'c.legal_name',
                'c.document',
                'c.email',
                'c.phone',
                'c.image',
                'c.image_banner',
                'c.primary_color',
                'c.secondary_color',
                'c.domain',
                'c.zip_code',
                'c.state',
                'c.city',
                'c.neighborhood',
                'c.street',
                'c.number',
                'c.complement',
                'c.is_active',
                'cdo.id as owner_id',
                'cdo.name as owner_name',
                'cdc.id as user_created_id',
                'cdc.name as user_created_name',
                'cdu.id as user_updated_id',
                'cdu.name as user_updated_name',
                'cdd.id as user_deleted_id',
                'cdd.name as user_deleted_name',
                'c.created_at',
                'c.updated_at',
                'c.deleted_at',
            );

            $query = $this->applyFilter($query, $getCompanyFilterDto);
            $offset = ($getCompanyFilterDto->page - 1) * $getCompanyFilterDto->pageSize;
            $companies = $query->offset($offset)->limit($getCompanyFilterDto->pageSize)->get();

            return $this->mapper->map($companies);
        } catch (Exception $e) {
            Log::error('Erro ao filtrar categorias: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCompany(int $ownerId): CompanyEntity
    {
        $compay = Company::where('owner_id', $ownerId)->first();

        if (!$compay) {
            throw new CompanyNotFoundException("Este proprietário não possui uma empresa cadastrada.");
        }

        return GenericMapper::map($compay, CompanyEntity::class);
    }

    public function create(CreateCompanyDto $createCompanyDto): CompanyEntity
    {
        try {
            $company = Company::where('owner_id', $createCompanyDto->ownerId)->first();

            if ($company) {
                throw new CompanyNotFoundException("Empresa já cadastrada para este proprietário.");
            }

            $image = $this->saveImage($createCompanyDto->image);
            $imageBanner = $this->saveImage($createCompanyDto->imageBanner);

            $company = Company::create([
                'owner_id' => $createCompanyDto->ownerId,
                'fantasy_name' => $createCompanyDto->fantasyName,
                'description' => $createCompanyDto->description,
                'legal_name' => $createCompanyDto->legalName,
                'document' => $createCompanyDto->document,
                'email' => $createCompanyDto->email,
                'phone' => $createCompanyDto->phone,
                'image' => $image,
                'image_banner' => $imageBanner,
                'primary_color' => $createCompanyDto->primaryColor,
                'secondary_color' => $createCompanyDto->secondaryColor,
                'domain' => $createCompanyDto->domain,
                'zip_code' => $createCompanyDto->zipCode,
                'state' => $createCompanyDto->state,
                'city' => $createCompanyDto->city,
                'neighborhood' => $createCompanyDto->neighborhood,
                'street' => $createCompanyDto->street,
                'number' => $createCompanyDto->number,
                'complement' => $createCompanyDto->complement,
                'slogan' => $createCompanyDto->slogan,
                'is_active' => $createCompanyDto->isActive,
                'user_id_created' => $createCompanyDto->userIdCreated,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $companyEntity = GenericMapper::map($company, CompanyEntity::class);

            return $companyEntity;
        } catch (Exception $e) {
            Log::error('Erro ao criar categoria: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(string $companyId, CreateCompanyDto $createCompanyDto):  CompanyEntity
    {
        $company = Company::where('id', $companyId)
                    ->where('owner_id', $createCompanyDto->ownerId)
                    ->first();

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $image = $createCompanyDto->image ? $this->updateImage($companyId, $createCompanyDto->image, $company->image) : $company->image;
        $imageBanner = $createCompanyDto->imageBanner ? $this->updateImage($companyId, $createCompanyDto->imageBanner, $company->image_banner) : $company->image_banner;

        $company->update([
            'owner_id' => $createCompanyDto->ownerId,
            'fantasy_name' => $createCompanyDto->fantasyName,
            'description' => $createCompanyDto->description,
            'legal_name' => $createCompanyDto->legalName,
            'document' => $createCompanyDto->document,
            'email' => $createCompanyDto->email,
            'phone' => $createCompanyDto->phone,
            'image' => $image,
            'image_banner' => $imageBanner,
            'primary_color' => $createCompanyDto->primaryColor,
            'secondary_color' => $createCompanyDto->secondaryColor,
            'domain' => $createCompanyDto->domain,
            'zip_code' => $createCompanyDto->zipCode,
            'state' => $createCompanyDto->state,
            'city' => $createCompanyDto->city,
            'neighborhood' => $createCompanyDto->neighborhood,
            'street' => $createCompanyDto->street,
            'number' => $createCompanyDto->number,
            'complement' => $createCompanyDto->complement,
            'slogan' => $createCompanyDto->slogan,
            'is_active' => $createCompanyDto->isActive,
            'user_id_updated' => $createCompanyDto->userIdUpdated,
            'updated_at' => now(),
        ]);

        $companyEntity = GenericMapper::map($company, CompanyEntity::class);
        
        return $companyEntity;
    }

    public function delete(string $companyId, int $userIdDeleted): bool
    {
        $company = Company::where('id', $companyId)->first();

        if (!$company) {
            throw new CompanyNotFoundException('Empresa já foi deletada.');
        }

        if ($company && $company->image && Storage::disk('shop_storage')->exists($company->image)) {
            Storage::disk('shop_storage')->delete($company->image);
        }

        if ($company && $company->image_banner && Storage::disk('shop_storage')->exists($company->image_banner)) {
            Storage::disk('shop_storage')->delete($company->image_banner);
        }

        $company->user_id_updated = $userIdDeleted;
        $company->deleted_at = now();
        $company->save();

        return true;
    }

    private function applyFilter($query, GetCompanyFilterDto $getCompanyFilterDto)
    {
        if ($getCompanyFilterDto->id) {
            $query->where('c.id', $getCompanyFilterDto->id);
        }

        if ($getCompanyFilterDto->name) {
            $query->where('c.fantasy_name', 'like', '%' . $getCompanyFilterDto->name . '%');
        }

        return $query;
    }

    private function saveImage(UploadedFile $image): string
    {
        $imagePath = $image->store('companies', 'shop_storage');
        return $imagePath;
    }

    private function updateImage(string $companyId, UploadedFile $image, string $oldImage): string
    {
        $company = Company::find($companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        if ($company && $oldImage && Storage::disk('shop_storage')->exists($oldImage)) {
            Storage::disk('shop_storage')->delete($oldImage);
        }
        
        return $this->saveImage($image);
    }
}
