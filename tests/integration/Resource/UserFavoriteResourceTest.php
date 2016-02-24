<?php

namespace RayRutjes\Tsr\Test\Integration\Resource;

use RayRutjes\Tsr\Http\JsonResponse;
use RayRutjes\Tsr\Http\Request;
use RayRutjes\Tsr\Persistence\PdoSongRepository;
use RayRutjes\Tsr\Resource\UserFavoriteResource;
use RayRutjes\Tsr\Service\SongService;
use RayRutjes\Tsr\SongList;
use RayRutjes\Tsr\Test\Integration\IntegrationTestCase;

class UserFavoriteResourceTest extends IntegrationTestCase
{
    /**
     * @var UserFavoriteResource
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $repo = new PdoSongRepository($this->getConnection()->getConnection());
        $service = new SongService($repo);
        $this->resource = new UserFavoriteResource($service);
    }

    public function testCanAddASongToUserFavorites()
    {
        $expected = new JsonResponse(201);

        $request = new Request('POST', '/whatever', ['song_id' => 3]);
        $response = $this->resource->post('1', $request);

        $this->assertEquals($expected, $response);
    }

    public function testCanRemoveASongFromUserFavorites()
    {
        $expected = new JsonResponse(200);

        $response = $this->resource->delete('1', '3');

        $this->assertEquals($expected, $response);
    }

    public function testCanGetUserFavoriteSongs()
    {
        $expected = new JsonResponse(200, []);

        $response = $this->resource->list('1');
        $this->assertEquals($expected, $response);
    }

}
