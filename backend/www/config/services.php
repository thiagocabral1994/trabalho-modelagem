<?php

namespace Modelagem\Config;

use DI\Container;

$container = new Container();

$container->set('session', function () {
    return new \SlimSession\Helper();
});

return $container;
