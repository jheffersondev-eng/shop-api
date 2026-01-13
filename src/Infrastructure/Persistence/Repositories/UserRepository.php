<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Src\Application\Dto\Login\AuthDto;
use Src\Application\Dto\User\GetUserFilterDto;
use Src\Application\Exceptions\UserNotFoundException;
use Src\Application\Interfaces\Repositories\IUserRepository;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\User\UserDto;
use Src\Application\Interfaces\Repositories\IUserDetailRepository;
use Src\Application\Mappers\GenericMapper;
use Src\Application\Mappers\UsersMapper;
use Src\Domain\Entities\UserEntity;
use Src\Infrastructure\Persistence\Models\User;
use Src\Infrastructure\Persistence\Models\UserDetail;

class UserRepository implements IUserRepository
{
    protected UsersMapper $mapper;
    protected IUserDetailRepository $userDetailRepository;

    public function __construct(IUserDetailRepository $userDetailRepository)
    {
        $this->mapper = new UsersMapper();
        $this->userDetailRepository = $userDetailRepository;
    }

    public function getUsersByFilter(GetUserFilterDto $getUserFilterDto): array
    {
        try {
            $query = DB::table('users as u')
            ->join('user_details as ud', 'u.id', '=', 'ud.user_id')
            ->leftJoin('profiles as p', 'u.user_id_created', '=', 'p.id')
            ->leftJoin('user_details as udo', 'u.owner_id', '=', 'udo.user_id')
            ->leftJoin('user_details as udc', 'u.user_id_created', '=', 'udc.user_id')
            ->leftJoin('user_details as udu', 'u.user_id_updated', '=', 'udu.user_id')
            ->leftJoin('user_details as udd', 'u.user_id_deleted', '=', 'udd.user_id')
            ->select(
                'u.id as id',
                'u.email',
                'u.profile_id',
                'u.owner_id',
                'ud.user_id',
                'u.is_active',
                'u.created_at',
                'u.updated_at',
                'u.deleted_at',
                'u.verification_code',
                'u.verification_expires_at',
                'u.email_verified_at',
                'ud.name as name',
                'ud.document',
                'ud.phone',
                'ud.birth_date',
                'ud.image',
                'ud.address',
                'ud.credit_limit',
                'p.id as profile_id',
                'p.name as profile_name',
                'p.description as profile_description', 
                'udo.user_id as owner_id',
                'udo.name as owner_name',
                'udc.user_id as user_id_created',
                'udc.name as user_created_name',
                'udu.user_id as user_id_updated',
                'udu.name as user_updated_name',
                'udd.user_id as user_id_deleted',
                'udd.name as user_deleted_name'
            );

            $query = $this->applyFilter($query, $getUserFilterDto);
            $offset = ($getUserFilterDto->page - 1) * $getUserFilterDto->pageSize;
            $users = $query->offset($offset)->limit($getUserFilterDto->pageSize)->get();

            return $this->mapper->map($users);
        } catch (Exception $e) {
            Log::error('Erro ao filtrar usuários: ' . $e->getMessage());
            throw $e;
        }
    }

    private function applyFilter($query, GetUserFilterDto $getUserFilterDto)
    {
        $query->where('u.owner_id', $getUserFilterDto->ownerId);

        if ($getUserFilterDto->id) {
            $query->where('u.id', $getUserFilterDto->id);
        }

        if ($getUserFilterDto->name) {
            $query->where('ud.name', 'like', '%' . $getUserFilterDto->name . '%');
        }

        if ($getUserFilterDto->email) {
            $query->where('u.email', 'like', '%' . $getUserFilterDto->email . '%');
        }

        if ($getUserFilterDto->document) {
            $query->where('ud.document', 'like', '%' . $getUserFilterDto->document . '%');
        }

        if ($getUserFilterDto->profileId) {
            $query->where('u.profile_id', $getUserFilterDto->profileId);
        }

        if ($getUserFilterDto->isActive !== null) {
            $query->where('u.is_active', $getUserFilterDto->isActive);
        }

        return $query;
    }

    public function create(UserDto $userDto): UserEntity
    {
        $user = User::create([
            'email' => $userDto->email,
            'password' => Hash::make($userDto->password),
            'profile_id' => $userDto->profileId,
            'owner_id' => $userDto->ownerId,
            'user_id_created' => $userDto->userIdCreated,
            'is_active' => $userDto->isActive,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return GenericMapper::map($user, UserEntity::class);
    }

    public function update(int $userId, UserDto $userDto): UserEntity
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                throw new UserNotFoundException('Usuário não encontrado.');
            }

            if ($userDto->password) {
                $user->password = Hash::make($userDto->password);
            }

            $user->profile_id = $userDto->profileId ?? $user->profile_id;
            $user->is_active = $userDto->isActive;
            $user->user_id_updated = $userDto->userIdUpdated;
            $user->updated_at = now();
            $user->save();

            $userDetail = UserDetail::where('user_id', $userId)->first();

            $this->userDetailRepository->update($userDto->userDetailsDto);

            return GenericMapper::map($user, UserEntity::class);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    public function save(UserEntity $userEntity): UserEntity
    {
        $user = User::find($userEntity->id);

        if (!$user) {
            throw new Exception("Usuário não encontrado.");
        }
        
        $user->email = $userEntity->email;
        $user->owner_id = $userEntity->ownerId;
        $user->profile_id = $userEntity->profileId;
        $user->is_active = $userEntity->isActive;
        $user->user_id_created = $userEntity->userIdCreated;
        $user->user_id_updated = $userEntity->userIdUpdated;
        $user->created_at = $userEntity->createdAt;
        $user->updated_at = $userEntity->updatedAt;
        $user->verification_code = $userEntity->verificationCode;
        $user->verification_expires_at = $userEntity->verificationExpiresAt;
        $user->save();
        
        return GenericMapper::map($user, UserEntity::class);
    }

    public function delete(int $userId, int $userIdDeleted): bool
    {
        try {
            $user = User::where('id', $userId)->first();

            if (!$user) {
                throw new UserNotFoundException('Usuário já foi deletado.');
            }

            $user->user_id_updated = $userIdDeleted;
            $user->deleted_at = now();
            $user->save();

            return true;
        } catch (Exception $e) {
            Log::error('Erro ao deletar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findByEmail(string $email): UserEntity|null
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return null;
        }

        $userEntity = GenericMapper::map($user, UserEntity::class);
        return $userEntity;
    }

    public function findById(int $id): UserEntity|null
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return null;
        }

        $userEntity = GenericMapper::map($user, UserEntity::class);
        return $userEntity;
    }

    public function checkPassword(UserEntity $user, string $password): bool
    {
        $user = User::where('id', $user->id)->first();
        return Hash::check($password, $user->password);
    }

    public function authenticate(AuthDto $authDto): string
    {
        $user = User::where('email', $authDto->email)->first();
        return $user->createToken('api-token')->plainTextToken;
    }
}
