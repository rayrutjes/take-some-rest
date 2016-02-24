<?php

namespace RayRutjes\Tsr;

use RayRutjes\Tsr\Util\Arrayable;

final class User implements Arrayable
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @param int    $userId
     * @param string $name
     * @param string $email
     */
    public function __construct(int $userId, string $name, string $email)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'name'    => $this->name,
            'email'   => $this->email,
        ];
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public static function fromArray(array $data): User
    {
        return new self($data['user_id'], $data['name'], $data['email']);
    }
}
