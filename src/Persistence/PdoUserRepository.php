<?php

namespace RayRutjes\Tsr\Persistence;

use RayRutjes\Tsr\User;

final class PdoUserRepository implements UserRepositoryInterface
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
     * @param $userId
     *
     * @return User
     *
     * @throws NotFoundException
     */
    public function getById(int $userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id = :user_id LIMIT 1');
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (false === $result) {
            throw new NotFoundException(sprintf('No user found with id: %d', $userId));
        }

        return User::fromArray($result);
    }
}
