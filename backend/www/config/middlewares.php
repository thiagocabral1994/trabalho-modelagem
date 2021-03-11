<?php

namespace Modelagem\Config;

use Modelagem\Middleware\PermissaoMiddleware;
use Tuupola\Middleware\JwtAuthentication;

$adm_midd = new PermissaoMiddleware([
    \Modelagem\Model\Permissao::ADMIN
]);

$jwt_midd = new JwtAuthentication([
    'secret' => getenv('JWT_SECRET_KEY'),
    'attribute' => 'jwt',
]);
