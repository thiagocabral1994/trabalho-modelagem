<?php
namespace Modelagem\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Modelagem\DAO\PermissaoDAO;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class PermissaoMiddleware implements MiddlewareInterface
{
    /**
     * @var array
     */
    protected $permissions;

    /**
     * @param array $permissions Array com o ID das permissões.
     */
    public function __construct(array $permissions)
    {
        $this->permissions = $permissions;
    }

    public function process(Request $request, Handler $handler): Response
    {
        $dao = new PermissaoDAO();
        $user_id = $request->getAttribute('jwt')['sub'];
        $user_perms = $dao->listByUser($user_id);

        foreach ($this->permissions as $permission) {
            foreach ($user_perms as $user_permission) {
                if ($permission == $user_permission['nome']) {
                    return $handler->handle($request);
                }
            }
        }
        $response = new \Slim\Psr7\Response();
        $msg = array('erro' => 'Você não tem permissão.');
        $response->getBody()->write(json_encode($msg));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED);
    }
}
