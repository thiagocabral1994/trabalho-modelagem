<?php

namespace Modelagem\Controller;

use Psr\Container\ContainerInterface;

class PermissaoController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }
}
