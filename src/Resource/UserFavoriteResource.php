<?php

namespace RayRutjes\Tsr\Resource;

use RayRutjes\Tsr\Http\JsonResponse;
use RayRutjes\Tsr\Http\Request;
use RayRutjes\Tsr\Service\SongService;

final class UserFavoriteResource
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
     * @param $userId
     *
     * @return JsonResponse
     */
    public function list($userId): JsonResponse
    {
        $songList = $this->songService->getUserFavoriteSongs($userId);

        return new JsonResponse(JsonResponse::STATUS_OK, $songList->toArray());
    }

    /**
     * @param         $userId
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function post($userId, Request $request): JsonResponse
    {
        $body = $request->getBody();
        if (!isset($body['song_id'])) {
            throw new \RuntimeException('Bad request, missing song_id.');
        }

        $this->songService->addSongToUserFavorites($userId, $body['song_id']);

        return new JsonResponse(JsonResponse::STATUS_CREATED);
    }

    /**
     * @param   $userId
     * @param   $songId
     *
     * @return JsonResponse
     */
    public function delete($userId, $songId): JsonResponse
    {
        $this->songService->removeSongFromUserFavorites($userId, $songId);

        return new JsonResponse(JsonResponse::STATUS_OK);
    }
}
