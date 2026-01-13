<?php

namespace Src\Application\Services\Profile;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Profile\CreateProfileDto;
use Src\Application\Dto\Profile\GetProfileFilterDto;
use Src\Application\Dto\Profile\UpdateProfileDto;
use Src\Application\Exceptions\ProfileNotFoundException;
use Src\Application\Interfaces\Repositories\IProfileRepository;
use Src\Application\Interfaces\Services\IProfileService;

class ProfileService implements IProfileService
{
    public function __construct(
        private IProfileRepository $profileRepository
    ) {}

    public function getProfilesByFilter(GetProfileFilterDto $getProfileFilterDto): ServiceResult
    {
        try {
            $data = $this->profileRepository->getProfilesByFilter($getProfileFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Perfis filtrados com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao filtrar perfis: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(CreateProfileDto $createProfileDto): ServiceResult
    {
        try {
            $profile = $this->profileRepository->create($createProfileDto);

            return ServiceResult::ok(
                data: $profile,
                message: 'Perfil criado com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao criar perfil: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(int $profileId, int $userIdDeleted): ServiceResult
    {
        try {
            $this->profileRepository->delete($profileId, $userIdDeleted);
            
            return ServiceResult::ok(
                data: null,
                message: 'Perfil excluído com sucesso.'
            );
        } catch (ProfileNotFoundException $e) {
            Log::error('Perfil não encontrado: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao excluir perfil: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(int $profileId, UpdateProfileDto $updateProfileDto): ServiceResult
    {
        try {
            $profile = $this->profileRepository->update($profileId, $updateProfileDto);
            
            return ServiceResult::ok(
                data: $profile,
                message: 'Perfil atualizado com sucesso.'
            );
        } catch (ProfileNotFoundException $e) {
            Log::error('Perfil não encontrado: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar perfil: ' . $e->getMessage());
            throw $e;
        }
    }
}
