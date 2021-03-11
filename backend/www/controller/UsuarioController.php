<?php

namespace Modelagem\Controller;

use Fig\Http\Message\StatusCodeInterface;
use Modelagem\Logic\UsuarioLogic;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UsuarioController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $request_user = $request->getAttribute('jwt')['sub'];

        if ($args['id'] != $request_user) {
            return parent::delete($request, $response, $args);
        }
        $msg = array('erro' => 'Está tentando se deletar?');
        $status_code = StatusCodeInterface::STATUS_BAD_REQUEST;

        $response->getBody()->write(json_encode($msg));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status_code);
    }
}
