<?php

namespace RayRutjes\Tsr\Test\Integration\Persistence;

use RayRutjes\Tsr\Persistence\PdoSongRepository;
use RayRutjes\Tsr\SongList;
use RayRutjes\Tsr\Test\Integration\IntegrationTestCase;
use RayRutjes\Tsr\Song;

class PdoSongRepositoryTest extends IntegrationTestCase
{
    /**
     * @var PdoSongRepository
     */
    private $repository;


    protected function setUp()
    {
        parent::setUp();
        $this->repository = new PdoSongRepository($this->getConnection()->getConnection());
    }


    public function testCanGetASongById()
    {
        $expected = new Song(3, 'Song 3', 315);
        $song = $this->repository->getById(3);

        $this->assertEquals($expected, $song);
    }

    /**
     * @expectedException \RayRutjes\Tsr\Persistence\NotFoundException
     */
    public function testThrowsNotFoundException()
    {
        $this->repository->getById(666);
    }

    public function testCanAddRemoveAndFetchUserFavorites()
    {
        $song2 = new Song(2, 'Song 2', 200);
        $song3 = new Song(3, 'Song 3', 315);

        // User 1 favorited 1 song.
        $expectedUser1Favorites = SongList::fromArray([$song3]);
        $this->repository->addSongToUserFavorites(1, 3);

        // User 2 favorited 2 songs.
        $expectedUser2Favorites = SongList::fromArray([$song2, $song3]);
        $this->repository->addSongToUserFavorites(2, 2);
        $this->repository->addSongToUserFavorites(2, 3);

        $user1Favorites = $this->repository->getUserFavoriteSongs(1);
        $user2Favorites = $this->repository->getUserFavoriteSongs(2);

        $this->assertEquals($expectedUser1Favorites, $user1Favorites);
        $this->assertEquals($expectedUser2Favorites, $user2Favorites);

        // Test that a song can be removed from a favorite list.
        $this->repository->removeSongFromUserFavorites(1, 3);
        $user1Favorites = $this->repository->getUserFavoriteSongs(1);
        $this->assertEquals(SongList::fromArray(), $user1Favorites);
    }
}
