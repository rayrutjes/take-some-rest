<?php

namespace RayRutjes\Tsr\Persistence;

use RayRutjes\Tsr\Song;
use RayRutjes\Tsr\SongList;

final class PdoSongRepository implements SongRepositoryInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $songId
     *
     * @return Song
     *
     * @throws NotFoundException
     */
    public function getById(int $songId): Song
    {
        $stmt = $this->pdo->prepare('SELECT * FROM songs WHERE song_id = :song_id LIMIT 1');
        $stmt->bindValue(':song_id', $songId, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new NotFoundException(sprintf('No song found with id: %d', $songId));
        }

        return Song::fromArray($result);
    }

    /**
     * @param $userId
     *
     * @return SongList
     */
    public function getUserFavoriteSongs(int $userId): SongList
    {
        $sql = <<<'EOD'
SELECT * FROM songs
INNER JOIN user_favorites ON user_favorites.song_id = songs.song_id
WHERE user_favorites.user_id = :user_id
EOD;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();

        $songs = [];
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $songs[] = Song::fromArray($result);
        }

        return SongList::fromArray($songs);
    }

    /**
     * @param $userId
     * @param $songId
     */
    public function addSongToUserFavorites(int $userId, int $songId)
    {
        $sql = 'INSERT INTO user_favorites (user_id, song_id) VALUES (:user_id, :song_id)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':song_id', $songId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @param $userId
     * @param $songId
     */
    public function removeSongFromUserFavorites(int $userId, int $songId)
    {
        $sql = 'DELETE FROM user_favorites WHERE user_id = :user_id AND song_id = :song_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':song_id', $songId, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
