<?php
namespace App\Dto\Response\Transformer;

use App\Dto\Response\UserResponseDto;
use App\Entity\User;

class UserResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param User $user
     *
     * @return UserResponseDto
     */
    public function transformFromObject($user): UserResponseDto
    {
        $dto = new UserResponseDto();

        if ($user instanceof User) {
            $dto->id = $user->getId();
            $dto->email = $user->getEmail();
            $dto->username = $user->getUsername();
        }

        return $dto;
    }
}