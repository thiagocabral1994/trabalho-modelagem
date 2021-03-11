<?php

namespace Modelagem\Middleware;

use ArrayAccess;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Server\MiddlewareInterface;
use Respect\Validation\Validator as Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Respect\Validation\Exceptions\NestedValidationException;

class ValidationMiddleware implements MiddlewareInterface
{
    private Validator $validator;
    
    /**
     * @param \Respect\Validation\Validator|array $validation
     */
    public function __construct($validation)
    {
        if (is_array($validation) || $validation instanceof ArrayAccess) {
            $this->validator = $this->toValidator($validation);
        } elseif ($validation instanceof Validator) {
            $this->validator = $validation;
        } else {
            throw new \InvalidArgumentException(
                '$validation must be either of type ' . Validator::class . 'or array'
            );
        }
    }

    public function process(Request $request, Handler $handler): Response
    {
        try {
            $this->validator->assert(
                $request->getParsedBody()
            );
        } catch (NestedValidationException $exception) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(
                json_encode($exception->getMessages())
            );
            return $response
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST)
                ->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }

    private function toValidator($field_validators): \Respect\Validation\Validator
    {
        $validator = Validator::arrayType();

        foreach ($field_validators as $field => $validation) {
            $validator->key($field, $validation);
        }
        return $validator;
    }
}
