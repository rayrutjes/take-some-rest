<?php

namespace RayRutjes\Tsr\Persistence;

use RayRutjes\Tsr\User;

interface UserRepositoryInterface
{
    /**
     * @param $userId
     *
     * @return User
     *
     * @throws NotFoundException
     */
    public function getById(int $userId);
}
