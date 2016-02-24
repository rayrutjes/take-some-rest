<?php

namespace RayRutjes\Tsr\Test\Integration\Resource;

use RayRutjes\Tsr\Http\JsonResponse;

use RayRutjes\Tsr\Persistence\PdoSongRepository;
use RayRutjes\Tsr\Resource\SongResource;
use RayRutjes\Tsr\Service\SongService;
use RayRutjes\Tsr\Test\Integration\IntegrationTestCase;

class SongResourceTest extends IntegrationTestCase
{
    /**
     * @var SongResource
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $repo = new PdoSongRepository($this->getConnection()->getConnection());
        $service = new SongService($repo);
        $this->resource = new SongResource($service);
    }

    public function testCanGetASongById()
    {
        $expected = new JsonResponse(200, [
            'song_id' => 2,
            'title' => 'Song 2',
            'duration' => 200,
        ]);

        $response = $this->resource->get("2");
        $this->assertEquals($expected, $response);
    }

    /**
     * @expectedException \RayRutjes\Tsr\Persistence\NotFoundException
     */
    public function testNotFound()
    {
        $this->resource->get("666");
    }



}
