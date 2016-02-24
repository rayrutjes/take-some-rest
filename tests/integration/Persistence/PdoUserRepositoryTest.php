<?php

namespace RayRutjes\Tsr\Test\Integration\Persistence;

use RayRutjes\Tsr\Persistence\PdoUserRepository;
use RayRutjes\Tsr\Test\Integration\IntegrationTestCase;
use RayRutjes\Tsr\User;

class PdoUserRepositoryTest extends IntegrationTestCase
{

    public function testCanGetAUserById()
    {
        $expected = new User(1, 'User 1 name', 'user1@example.com');

        $repo = new PdoUserRepository($this->getConnection()->getConnection());
        $user = $repo->getById(1);

        $this->assertEquals($expected, $user);
    }

    /**
     * @expectedException \RayRutjes\Tsr\Persistence\NotFoundException
     */
    public function testThrowsNotFoundException()
    {
        $repo = new PdoUserRepository($this->getConnection()->getConnection());
        $repo->getById(666);
    }
}
