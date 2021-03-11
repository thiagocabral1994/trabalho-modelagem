<?php

use Slim\Factory\AppFactory;
use Modelagem\Middleware\CORSMiddleware;

define('BASE_DIR', dirname(__DIR__));
define('CONFIG_DIR', BASE_DIR . '/config');
define('ROUTES_DIR', BASE_DIR . '/routes');

require_once BASE_DIR . '/vendor/autoload.php';
require_once CONFIG_DIR . '/env.php';
require_once CONFIG_DIR . '/app_factory.php';
require_once CONFIG_DIR . '/middlewares.php';
require_once CONFIG_DIR . '/validation.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(CORSMiddleware::class);

#====================================== ROTAS ======================================#

$app->group('/', include ROUTES_DIR . '/auth.php');
$app->group('/perfis', include ROUTES_DIR . '/grupo.php');
$app->group('/usuarios', include ROUTES_DIR . '/usuario.php')
    ->add($jwt_midd);
$app->group('/permissoes', include ROUTES_DIR . '/permissao.php');
$app->group('/atividades', include ROUTES_DIR . '/atividade.php');
$app->group('/cursos', include ROUTES_DIR . '/curso.php');
$app->group('/ocorrencias', include ROUTES_DIR . '/ocorrencia.php');
$app->group('/status', include ROUTES_DIR . '/status.php');
$app->group('/turmas', include ROUTES_DIR . '/turma.php');
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

#===================================================================================#

$app->run();
