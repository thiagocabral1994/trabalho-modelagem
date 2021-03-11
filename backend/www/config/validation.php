<?php

namespace Modelagem\Config;

use Respect\Validation\Factory;

Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('Modelagem\\Validation\\Rule')
        ->withExceptionNamespace('Modelagem\\Validation\\Exception')
);
