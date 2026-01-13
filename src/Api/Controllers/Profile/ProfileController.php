<?php

namespace Src\Api\Controllers\Profile;

use Illuminate\Support\Facades\Auth;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Profile\CreateProfileRequest;
use Src\Api\Requests\Profile\ProfileByFilterRequest;
use Src\Api\Requests\Profile\UpdateProfileRequest;
use Src\Application\Interfaces\Services\IProfileService;

class ProfileController extends BaseController
{
    public function __construct(
        private IProfileService $profileService
    ) {}

    public function getProfilesByFilter(ProfileByFilterRequest $request)
    {        
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->profileService->getProfilesByFilter($dto),
            statusCodeSuccess: 200
        );
    }

    public function create(CreateProfileRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->profileService->create($dto),
            statusCodeSuccess: 201
        );
    }

    public function delete(int $id)
    {
        return $this->execute(
            callback: fn() => $this->profileService->delete($id, Auth::id()),
            statusCodeSuccess: 200
        );
    }

    public function update(int $id, UpdateProfileRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->profileService->update($id, $dto),
            statusCodeSuccess: 200
        );
    }
}