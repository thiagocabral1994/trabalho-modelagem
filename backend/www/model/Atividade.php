<?php

namespace Modelagem\Model;

final class Atividade extends Model
{
    public string $titulo;
    public string $descricao;
    public string $anexo;
    public int $id_turma;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->titulo = $obj['titulo'];
        $this->descricao = $obj['descricao'];
        $this->anexo = $obj['anexo'];
        $this->id_turma = $obj['id_turma'];
        return parent::init($obj);
    }
}
