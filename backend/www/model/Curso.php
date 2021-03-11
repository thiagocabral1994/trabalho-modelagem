<?php

namespace Modelagem\Model;

final class Curso extends Model
{
    public string $nome;
    public string $descricao;
    public int $duracao;
    public string $ementa;
    public bool $ativo;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->nome = $obj['nome'];
        $this->descricao = $obj['descricao'];
        $this->duracao = $obj['duracao'];
        $this->ementa = $obj['ementa'];
        $this->ativo = $obj['ativo'];
        return parent::init($obj);
    }
}
