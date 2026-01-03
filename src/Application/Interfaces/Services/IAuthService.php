<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Login\AuthDto;
use Src\Application\Services\ServiceResult;

interface IAuthService
{
    public function authenticate(AuthDto $authDto): ServiceResult;
}
