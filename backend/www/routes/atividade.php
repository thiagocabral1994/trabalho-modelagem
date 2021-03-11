<?php

namespace Modelagem\Rotas;

use Respect\Validation\Validator as Respect;
use Modelagem\Controller\AtividadeController;
use Modelagem\Middleware\ValidationMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $group) {
    $controller = AtividadeController::class;

    $group->get('', $controller . ':list');
    $group->post('', $controller . ':save');
    $group->get('/listByClass/{id:[1-9]+}', $controller . ':listByClass');
    $group->get('/{id:[1-9]+}', $controller . ':getById');
    $group->delete('/{id:[1-9]+}', $controller . ':delete');
};
