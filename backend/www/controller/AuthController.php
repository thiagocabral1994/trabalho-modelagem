<?php

namespace Modelagem\Controller;

use Modelagem\Logic\AuthLogic;
use Psr\Container\ContainerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $msg = AuthLogic::login($data['cpf'], $data['senha']);

        if (isset($msg)) {
            $status_code = StatusCodeInterface::STATUS_OK;
        } else {
            $msg = array('erro' => 'Dados inválidos');
            $status_code = StatusCodeInterface::STATUS_BAD_REQUEST;
        }

        $response->getBody()->write(json_encode($msg));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status_code);
    }

    public function loginWithToken(Request $request, Response $response, array $args): Response
    {
        $token_decoded = $request->getAttribute('jwt');
        $usuario = AuthLogic::loginWithToken($token_decoded);

        if (isset($usuario)) {
            $msg = $usuario;
            $status_code = StatusCodeInterface::STATUS_OK;
        } else {
            $msg = ['erro' => true];
            $status_code = StatusCodeInterface::STATUS_BAD_REQUEST;
        }

        $response->getBody()->write(json_encode($msg));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status_code);
    }
}
