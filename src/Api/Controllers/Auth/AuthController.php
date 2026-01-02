<?php

namespace Src\Api\Controllers\Auth;

use Src\Application\Interfaces\Services\IAuthService;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Auth\AuthRequest;

class AuthController extends BaseController
{
    public function __construct(
        private IAuthService $authService
    ) {}

    public function login(AuthRequest $authRequest)
    {        
        $dto = $authRequest->getDto();

        return $this->execute(
            callback: fn() => $this->authService->authenticate($dto),
            statusCodeSuccess: 200
        );
    }
}
