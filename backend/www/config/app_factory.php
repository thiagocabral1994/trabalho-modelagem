<?php

namespace Modelagem\Config;

use Slim\Factory\AppFactory;

AppFactory::setContainer(include(CONFIG_DIR . '/services.php'));
