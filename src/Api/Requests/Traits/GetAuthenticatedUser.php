<?php

namespace Src\Api\Requests\Traits;

use Illuminate\Support\Facades\Auth;

trait GetAuthenticatedUser
{
    /**
     * Obtém o usuário autenticado
     */
    protected function getAuthenticatedUser()
    {
        return Auth::user();
    }

    /**
     * Obtém o ID do usuário autenticado
     */
    protected function getUserId(): int
    {
        return $this->getAuthenticatedUser()->id;
    }

    /**
     * Obtém o ID do owner do usuário (sua empresa/organização)
     * Se não existir, retorna o próprio ID do usuário
     */
    protected function getOwnerId(): int
    {
        $user = $this->getAuthenticatedUser();
        return $user->owner_id ?? $user->id;
    }
}
