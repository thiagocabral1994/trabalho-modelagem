<?php

namespace Modelagem\Model;

class Token extends Model
{
    public string $jwt;
    public string $refresh_token;
    public int $id_usuario;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->jwt = $obj['jwt'];
        $this->refresh_token = $obj['refresh'];
        $this->id_usuario = $obj['id_usuario'];
        return parent::init($obj);
    }
}
