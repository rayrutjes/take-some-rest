<?php

namespace RayRutjes\Tsr\Resource;

use RayRutjes\Tsr\Http\JsonResponse;
use RayRutjes\Tsr\Service\SongService;

final class SongResource
{
    /**
     * @var SongService
     */
    private $songService;

    /**
     * @param SongService $songService
     */
    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    /**
     * @param $songId
     *
     * @return JsonResponse
     */
    public function get(int $songId): JsonResponse
    {
        $song = $this->songService->getSongById($songId);

        return new JsonResponse(JsonResponse::STATUS_OK, $song->toArray());
    }
}
