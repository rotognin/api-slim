<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->get('/mensagens', function (Request $request, Response $response) {
        $frases = array(
            1 => 'Frase 1',
            2 => 'Frase 2',
            3 => 'Frase 3',
            4 => 'Frase 4',
            5 => 'Frase 5'
        );

        $numero = rand(1, 5);

        $response->getBody()->write($frases[$numero]);
        return $response;
    });

    $app->get('/busca', function (Request $request, Response $response) {
        $queryParams = $request->getQueryParams();
        $texto = $queryParams['q'] ?? '';

        if ($texto == '') {
            $response->getBody()->write('Nada foi informado');
        } else {
            $response->getBody()->write('Foi informado o termo ' . $texto);
        }

        return $response;
    });
};
