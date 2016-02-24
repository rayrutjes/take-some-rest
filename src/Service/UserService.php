<?php

namespace RayRutjes\Tsr\Service;

use RayRutjes\Tsr\Persistence\UserRepositoryInterface;
use RayRutjes\Tsr\User;

final class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $userId
     *
     * @return User
     */
    public function getUserById($userId): User
    {
        return $this->userRepository->getById((int) $userId);
    }
}
