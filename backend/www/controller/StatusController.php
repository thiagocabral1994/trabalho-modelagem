<?php

namespace Modelagem\Controller;

use Psr\Container\ContainerInterface;

final class StatusController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }
}
