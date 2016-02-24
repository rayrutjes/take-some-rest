<?php

require_once '../vendor/autoload.php';

$config = include '../config.php';

// Router.
$router = new \RayRutjes\Tsr\Http\Router();

// Shared PDO instance.
$pdo = new PDO($config['db_dsn'], $config['db_username'], $config['db_password']);

// UserResource.
$userRepository = new \RayRutjes\Tsr\Persistence\PdoUserRepository($pdo);
$userService = new \RayRutjes\Tsr\Service\UserService($userRepository);
$userResource = new \RayRutjes\Tsr\Resource\UserResource($userService);
$router->addRoute(
    new \RayRutjes\Tsr\Http\Route(
        'GET',
        '/users/:user_id',
        function(...$args) use ($userResource) {
            return $userResource->get(...$args);
        }
    )
);

// SongResource.
$songRepository = new \RayRutjes\Tsr\Persistence\PdoSongRepository($pdo);
$songService = new \RayRutjes\Tsr\Service\SongService($songRepository);
$songResource = new \RayRutjes\Tsr\Resource\SongResource($songService);
$router->addRoute(
    new \RayRutjes\Tsr\Http\Route(
        'GET',
        '/songs/:song_id',
        function(...$args) use ($songResource) {
            return $songResource->get(...$args);
        }
    )
);

// UserFavoriteResource.
$userFavoriteResource = new \RayRutjes\Tsr\Resource\UserFavoriteResource($songService);
$router->addRoute(
    new \RayRutjes\Tsr\Http\Route(
        'GET',
        '/users/:user_id/favorites',
        function(...$args) use ($userFavoriteResource) {
            return $userFavoriteResource->list(...$args);
        }
    )
);
$router->addRoute(
    new \RayRutjes\Tsr\Http\Route(
        'POST',
        '/users/:user_id/favorites',
        function(...$args) use ($userFavoriteResource) {
            return $userFavoriteResource->post(...$args);
        }
    )
);
$router->addRoute(
    new \RayRutjes\Tsr\Http\Route(
        'DELETE',
        '/users/:user_id/favorites/:song_id',
        function(...$args) use ($userFavoriteResource) {
            return $userFavoriteResource->delete(...$args);
        }
    )
);


// Handle the incoming request.
$server = new \RayRutjes\Tsr\Http\Server($router);
$server->run();