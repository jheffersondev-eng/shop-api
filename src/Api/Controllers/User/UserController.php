<?php

namespace Src\Api\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\User\CreateUserRequest;
use Src\Api\Requests\User\RegisterUserRequest;
use Src\Api\Requests\User\UserByFilterRequest;
use Src\Api\Requests\User\UpdateUserRequest;
use Src\Application\Interfaces\Services\IUserService;

class UserController extends BaseController
{
    public function __construct(
        private IUserService $userService
    ) {}

    public function getUsersByFilter(UserByFilterRequest $request)
    {        
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->userService->getUsersByFilter($dto),
            statusCodeSuccess: 200
        );
    }

    public function create(CreateUserRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->userService->create($dto),
            statusCodeSuccess: 201
        );
    }

    public function register(RegisterUserRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->userService->create($dto),
            statusCodeSuccess: 201
        );
    }

    public function update(int $id, UpdateUserRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->userService->update($id, $dto),
            statusCodeSuccess: 200
        );
    }

    public function delete(int $id)
    {
        return $this->execute(
            callback: fn() => $this->userService->delete($id, Auth::id()),
            statusCodeSuccess: 200
        );
    }
}
