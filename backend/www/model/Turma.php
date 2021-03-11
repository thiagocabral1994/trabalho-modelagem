<?php

namespace Modelagem\Model;

final class Turma extends Model
{
    public int $quantidade_alunos;
    public int $id_usuario;
    public int $id_status;
    public bool $ativo;
    public int $id_curso;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->quantidade_alunos = $obj['quantidade_alunos'];
        $this->id_usuario = $obj['id_usuario'];
        $this->id_status = $obj['id_status'];
        $this->ativo = $obj['ativo'];
        $this->id_curso = $obj['id_curso'];
        return parent::init($obj);
    }
}
