<?php

namespace Modelagem\Controller;

use Psr\Container\ContainerInterface;

final class CursoController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }
}
