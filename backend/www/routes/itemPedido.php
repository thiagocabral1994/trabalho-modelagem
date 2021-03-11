<?php

namespace Modelagem\Rotas;

use Respect\Validation\Validator as Respect;
use Modelagem\Controller\ItemPedidoController;
use Modelagem\Middleware\ValidationMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $group) {
    $controller = ItemPedidoController::class;
    $group->get('/listByPedido/{id_pedido:[1-9]+}', $controller . ':list');
    $group->post('', $controller . ':save');
    $group->post('/saveList', $controller . ':saveList');
    $group->get('/{id:[1-9]+}', $controller . ':getById');
    $group->delete('/{id:[1-9]+}', $controller . ':delete');
};
