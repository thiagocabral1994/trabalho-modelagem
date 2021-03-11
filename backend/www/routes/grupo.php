<?php

namespace Modelagem\Rotas;

use Modelagem\Controller\GrupoController;
use Modelagem\Middleware\ValidationMiddleware;
use Respect\Validation\Validator as Respect;
use Slim\Routing\RouteCollectorProxy as Group;

return function (Group $group) {
    $controller = GrupoController::class;

    $group->get('', $controller . ':list');
    $group->post('', $controller . ':save');
    $group->get('/{id:[1-9]\d*}', $controller . ':getById');
    $group->delete('/{id:[1-9]\d*}', $controller . ':delete');
};
