<?php

namespace Modelagem\Rotas;

use Modelagem\Controller\PermissaoController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $group) {
    $controller = PermissaoController::class;

    $group->get('', $controller . ':list');
};
