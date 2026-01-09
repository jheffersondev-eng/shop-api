<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Src\Application\Dto\User\UserDetailsDto;
use Src\Infrastructure\Persistence\Models\UserDetail;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Src\Application\Interfaces\Repositories\IUserDetailRepository;
use Src\Application\Mappers\GenericMapper;
use Src\Domain\Entities\UserDetailsEntity;

class UserDetailRepository implements IUserDetailRepository
{
    protected UserDetail $model;
    
    public function __construct()
    { 
        $this->model = new UserDetail();
    }

    public function findByDocument(string $document): UserDetailsEntity|null
    {
        $userDetail = UserDetail::where('document', $document)->first();
        return $userDetail ? GenericMapper::map($userDetail, UserDetailsEntity::class) : null;
    }

    public function getUserDetailByUserId(int $userId): UserDetailsEntity|null
    {
        $userDetail = UserDetail::where('user_id', $userId)->first();
        return $userDetail ? GenericMapper::map($userDetail, UserDetailsEntity::class) : null;
    }

    public function create(UserDetailsDto $userDetailsDto, int $userId): UserDetailsEntity
    {
        $userDetail = UserDetail::create([
            'user_id' => $userId,
            'name' => $userDetailsDto->name,
            'document' => $userDetailsDto->document,
            'birth_date' => $userDetailsDto->birthDate->format('Y-m-d H:i:s'),
            'phone' => $userDetailsDto->phone,
            'address' => $userDetailsDto->address,
            'credit_limit' => $userDetailsDto->creditLimit,
            'image' => $userDetailsDto->image,
        ]);

        $userDetailEntity = GenericMapper::map($userDetail, UserDetailsEntity::class);

        return $userDetailEntity;
    }

    public function delete(int $id): UserDetailsEntity
    {
        $userDetail = $this->model->where('user_id', $id)->first();

        if (!$userDetail) {
            return throw new Exception("Detalhes do usuário não encontrados.");
        }

        $userDetailDeleted = $userDetail->delete();
        
        return GenericMapper::map($userDetailDeleted, UserDetailsEntity::class);
    }

    public function update(UserDetailsDto $userDetailsDto): UserDetailsEntity
    {
        $userDetail = $this->model->where('user_id', $userDetailsDto->userId)->first();

        if (!$userDetail) {
            return throw new Exception("Detalhes do usuário não encontrados.");
        }

        $currentImage = $userDetail->image;

        if($userDetailsDto->image && $userDetailsDto->image !== $currentImage) {
            $this->deleteUserDetailsImage($currentImage);
        }

        $image = $this->createUserDetailsImages($userDetailsDto->image);

        $data = [
            'name' => $userDetailsDto->name,
            'document' => $userDetailsDto->document,
            'birth_date' => $userDetailsDto->birthDate->format('Y-m-d H:i:s'),
            'phone' => $userDetailsDto->phone,
            'address' => $userDetailsDto->address,
            'credit_limit' => $userDetailsDto->creditLimit,
            'image' => $image ?? $currentImage,
        ];
        
        $userDetail->update($data);
        $userDetail->refresh();
        
        return GenericMapper::map($userDetail, UserDetailsEntity::class);
    }

    private function createUserDetailsImages(string|UploadedFile|null $image): string|UploadedFile|null
    {
        $imagePath = null;

        if ($image instanceof UploadedFile) {
            $imagePath = $image->store('users', 'shop_storage');
        }

        return $imagePath;
    }

    private function deleteUserDetailsImage(string|null $imagePath): void
    {
        if ($imagePath && Storage::disk('shop_storage')->exists($imagePath)) {
            Storage::disk('shop_storage')->delete($imagePath);
        }
    }
}
