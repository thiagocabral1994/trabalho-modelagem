<?php

namespace Modelagem\Rotas;

use Modelagem\Controller\AuthController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $group) use ($jwt_midd) {
    $controller = AuthController::class;

    $group->post('login', $controller . ':login');
    $group
        ->post('login-jwt', $controller . ':loginWithToken')
        ->add($jwt_midd);
};
