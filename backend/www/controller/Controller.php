<?php

namespace Modelagem\Controller;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class Controller
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function getModelClass(): string
    {
        $class = substr(get_class($this), 0, -10);
        $class = substr($class, strrpos($class, '\\') + 1);
        $class = 'Modelagem\\Model\\' . $class;
        return $class;
    }

    protected function getLogicClass(): string
    {
        $class = substr(get_class($this), 0, -10);
        $class = substr($class, strrpos($class, '\\') + 1);
        $class = 'Modelagem\\Logic\\' . $class . 'Logic';
        return $class;
    }

    public function list(Request $request, Response $response, array $args): Response
    {
        $logic = $this->getLogicClass();
        $models = $logic::list();

        $response->getBody()->write(json_encode($models));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getById(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $logic = $this->getLogicClass();
        $model = $logic::get($id);

        if (is_null($model)) {
            $status_code = StatusCodeInterface::STATUS_NOT_FOUND;
            $msg = array("erro" => ["Recurso não encontrado"]);
        } else {
            $status_code = StatusCodeInterface::STATUS_OK;
            $msg = $model;
        }

        $msg = json_encode($msg, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($msg);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status_code);
    }

    public function save(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $modelClass = $this->getModelClass();
        $model = new $modelClass();

        try {
            $model->init($data);
            $logic = $this->getLogicClass();
            $logic::save($model);

            $msg = array('id' => $model->id);
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

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $logic = $this->getLogicClass();

        try {
            if ($logic::delete($id)) {
                $msg = array('erro' => false);
                $status_code = StatusCodeInterface::STATUS_OK;
            } else {
                $msg = array('erro' => 'erro ao deletar');
                $status_code = StatusCodeInterface::STATUS_BAD_REQUEST;
            }
        } catch (\Throwable $t) {
            $msg = array('erro' => $t->getMessage());
            $status_code = StatusCodeInterface::STATUS_BAD_REQUEST;
        }

        $response->getBody()->write(json_encode($msg));
        return $response
            ->withStatus($status_code)
            ->withHeader('Content-Type', 'application/json');
    }
}
