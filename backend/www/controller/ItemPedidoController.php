<?php

namespace Modelagem\Controller;

use Modelagem\Logic\ItemPedidoLogic;
use Modelagem\Model\ItemPedido;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ItemPedidoController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function list(Request $request, Response $response, array $args): Response 
    {
        $id_pedido = $args['id_pedido'];
        $items = ItemPedidoLogic::listByPedido($id_pedido);
        $response->getBody()->write(json_encode($items));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function saveList(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        if (!is_array($data) or empty($data) or empty($data['itens'])) {
            return $response->withStatus(
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        try {
            $itens = array();
            foreach($data['itens'] as $itemArray) {
                $item = new ItemPedido();
                $item->init($itemArray);
                $itens[] = $item;
            }
            ItemPedidoLogic::saveList($itens);
            $msg = array('msg' => 'OK');
            $status_code = StatusCodeInterface::STATUS_OK;
        } catch (\Throwable $t) {
            $msg = array('erro' => $t->getMessage());
            $status_code = StatusCodeInterface::STATUS_BAD_REQUEST;
        }

        $response->getBody()->write(json_encode($msg));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status_code);
    }
}
