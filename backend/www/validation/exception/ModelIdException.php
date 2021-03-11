<?php

namespace Modelagem\Validation\Exception;

use Respect\Validation\Exceptions\ValidationException;

final class ModelIdException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => '{{name}} deve ser um ID válido.'
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => '{{name}} não deve ser um ID válido.'
        ]
    ];
}
