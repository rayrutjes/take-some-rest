<?php

namespace RayRutjes\Tsr\Test\Integration\Resource;

use RayRutjes\Tsr\Http\JsonResponse;

use RayRutjes\Tsr\Persistence\PdoUserRepository;
use RayRutjes\Tsr\Resource\UserResource;
use RayRutjes\Tsr\Service\UserService;
use RayRutjes\Tsr\Test\Integration\IntegrationTestCase;

class UserResourceTest extends IntegrationTestCase
{
    /**
     * @var UserResource
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $repo = new PdoUserRepository($this->getConnection()->getConnection());
        $service = new UserService($repo);
        $this->resource = new UserResource($service);
    }

    public function testCanGetAUserById()
    {
        $expected = new JsonResponse(200, [
            'user_id' => 2,
            'name' => 'User 2 name',
            'email' => 'user2@example.com',
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
