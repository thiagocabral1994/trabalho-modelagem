<?php

namespace Modelagem\Model;

final class Status extends Model
{
    public string $nome;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->nome = $obj['nome'];
        return parent::init($obj);
    }
}
