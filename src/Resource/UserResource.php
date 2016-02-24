<?php

namespace RayRutjes\Tsr\Resource;

use RayRutjes\Tsr\Http\JsonResponse;
use RayRutjes\Tsr\Service\UserService;

final class UserResource
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param $userId
     *
     * @return JsonResponse
     */
    public function get($userId): JsonResponse
    {
        $user = $this->userService->getUserById($userId);

        return new JsonResponse(JsonResponse::STATUS_OK, $user->toArray());
    }
}
