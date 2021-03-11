<?php

namespace Modelagem\Controller;

use Modelagem\Logic\AtividadeLogic;
use Psr\Container\ContainerInterface;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AtividadeController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function listByClass(Request $request, Response $response, array $args): Response 
    {
        $id_turma = $args['id_turma'];
        $items = AtividadeLogic::listByClass($id_turma);
        $response->getBody()->write(json_encode($items));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
