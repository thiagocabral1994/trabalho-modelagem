<?php

namespace Modelagem\Validation\Rule;

use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Validator;

final class ModelId extends AbstractRule
{
    public function validate($input): bool
    {
        $validator = Validator::intVal()->positive();
        return $validator->validate($input);
    }
}
