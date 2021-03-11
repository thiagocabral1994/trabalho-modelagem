<?php

namespace Modelagem\Model;

final class Permissao extends Model
{
    const ADMIN = 'ADMIN';

    public string $nome;

    public string $descricao;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->nome = $obj['nome'];
        $this->descricao = $obj['descricao'];
        return parent::init($obj);
    }
}
