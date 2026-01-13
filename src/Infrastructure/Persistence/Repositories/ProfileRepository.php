<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Profile\CreateProfileDto;
use Src\Application\Dto\Profile\GetProfileFilterDto;
use Src\Application\Dto\Profile\UpdateProfileDto;
use Src\Application\Exceptions\ProfileNotFoundException;
use Src\Application\Interfaces\Repositories\IProfileRepository;
use Src\Application\Mappers\GenericMapper;
use Src\Application\Mappers\ProfilesMapper;
use Src\Domain\Entities\ProfileEntity;
use Src\Infrastructure\Persistence\Models\Profile;

class ProfileRepository implements IProfileRepository
{
    private ProfilesMapper $mapper;

    public function __construct()
    {
        $this->mapper = new ProfilesMapper();
    }

    public function getProfilesByFilter(GetProfileFilterDto $getProfileFilterDto): array
    {
        try {
            $query = DB::table('profiles as p')
            ->leftJoin('user_details as cdo', 'p.owner_id', '=', 'cdo.id')
            ->leftJoin('user_details as cdc', 'p.user_id_created', '=', 'cdc.id')
            ->leftJoin('user_details as cdu', 'p.user_id_updated', '=', 'cdu.id')
            ->leftJoin('user_details as cdd', 'p.user_id_deleted', '=', 'cdd.id')
            ->select(
                'p.id',
                'p.name',
                'p.description',
                'p.permission',
                'cdo.id as owner_id',
                'cdo.name as owner_name',
                'cdc.id as user_created_id',
                'cdc.name as user_created_name',
                'cdu.id as user_updated_id',
                'cdu.name as user_updated_name',
                'cdd.id as user_deleted_id',
                'cdd.name as user_deleted_name',
                'p.created_at',
                'p.updated_at',
                'p.deleted_at',
            );

            $query = $this->applyFilter($query, $getProfileFilterDto);
            $offset = ($getProfileFilterDto->page - 1) * $getProfileFilterDto->pageSize;
            $profiles = $query->offset($offset)->limit($getProfileFilterDto->pageSize)->get();

            return $this->mapper->map($profiles);
        } catch (Exception $e) {
            Log::error('Erro ao filtrar perfis: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(CreateProfileDto $createProfileDto): ProfileEntity
    {
        try {
            $profile = Profile::create([
                'name' => $createProfileDto->name,
                'description' => $createProfileDto->description,
                'permission' => strtolower(implode(',', $createProfileDto->permissions)),
                'owner_id' => $createProfileDto->ownerId,
                'user_id_created' => $createProfileDto->userIdCreated,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $profileEntity = GenericMapper::map($profile, ProfileEntity::class);

            return $profileEntity;
        } catch (Exception $e) {
            Log::error('Erro ao criar perfil: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(int $profileId, UpdateProfileDto $updateProfileDto):  ProfileEntity
    {
        $profile = Profile::where('id', $profileId)
                    ->where('owner_id', $updateProfileDto->ownerId)
                    ->first();

        if (!$profile) {
            throw new ProfileNotFoundException();
        }

        $profile->update([
            'name' => $updateProfileDto->name,
            'description' => $updateProfileDto->description,
            'user_id_updated' => $updateProfileDto->userIdUpdated,
            'updated_at' => now(),
        ]);

        $profileEntity = GenericMapper::map($profile, ProfileEntity::class);
        
        return $profileEntity;
    }

    public function delete(int $profileId, int $userIdDeleted): bool
    {
        $profile = Profile::where('id', $profileId)->first();

        if (!$profile) {
            throw new ProfileNotFoundException('Perfil já foi deletado.');
        }

        $profile->user_id_updated = $userIdDeleted;
        $profile->deleted_at = now();
        $profile->save();

        return true;
    }

    private function applyFilter($query, GetProfileFilterDto $getProfileFilterDto)
    {
        $query->where('p.owner_id', $getProfileFilterDto->ownerId);

        if ($getProfileFilterDto->id) {
            $query->where('p.id', $getProfileFilterDto->id);
        }

        if ($getProfileFilterDto->name) {
            $query->where('p.name', 'like', '%' . $getProfileFilterDto->name . '%');
        }

        return $query;
    }
}