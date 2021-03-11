<?php

namespace Modelagem\Model;

final class Grupo extends Model
{
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
        if (isset($obj['permissoes'])) {
            $this->permissoes = $obj['permissoes'];
        }
        if (isset($obj['usuarios'])) {
            $this->usuarios = $obj['usuarios'];
        }
        return parent::init($obj);
    }
}
