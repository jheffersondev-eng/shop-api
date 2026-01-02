<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\DTOs\Login\AuthDto;
use Src\Application\DTOs\ServiceResult;

interface IAuthService
{
    public function authenticate(AuthDto $authDto): ServiceResult;
}
