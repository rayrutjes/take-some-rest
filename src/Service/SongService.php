<?php

namespace RayRutjes\Tsr\Service;

use RayRutjes\Tsr\Persistence\SongRepositoryInterface;
use RayRutjes\Tsr\Persistence\UserRepositoryInterface;
use RayRutjes\Tsr\Song;
use RayRutjes\Tsr\SongList;

final class SongService
{
    /**
     * @var UserRepositoryInterface
     */
    private $songRepository;

    /**
     * @param SongRepositoryInterface $songRepository
     */
    public function __construct(SongRepositoryInterface $songRepository)
    {
        $this->songRepository = $songRepository;
    }

    /**
     * @param $userId
     *
     * @return Song
     */
    public function getSongById($userId): Song
    {
        return $this->songRepository->getById((int) $userId);
    }

    /**
     * @param $userId
     *
     * @return SongList
     */
    public function getUserFavoriteSongs($userId): SongList
    {
        return $this->songRepository->getUserFavoriteSongs((int) $userId);
    }

    /**
     * @param $userId
     * @param $songId
     */
    public function addSongToUserFavorites($userId, $songId)
    {
        $this->songRepository->addSongToUserFavorites((int) $userId, (int) $songId);
    }

    /**
     * @param $userId
     * @param $songId
     */
    public function removeSongFromUserFavorites($userId, $songId)
    {
        $this->songRepository->removeSongFromUserFavorites((int) $userId, (int) $songId);
    }
}
