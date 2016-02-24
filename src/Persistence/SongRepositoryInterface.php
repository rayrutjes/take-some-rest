<?php

namespace RayRutjes\Tsr\Persistence;

use RayRutjes\Tsr\Song;
use RayRutjes\Tsr\SongList;

interface SongRepositoryInterface
{
    /**
     * @param $songId
     *
     * @return Song
     *
     * @throws NotFoundException
     */
    public function getById(int $songId): Song;

    /**
     * @param $userId
     *
     * @return SongList
     */
    public function getUserFavoriteSongs(int $userId): SongList;

    /**
     * @param $userId
     * @param $songId
     */
    public function addSongToUserFavorites(int $userId, int $songId);

    /**
     * @param $userId
     * @param $songId
     */
    public function removeSongFromUserFavorites(int $userId, int $songId);
}
