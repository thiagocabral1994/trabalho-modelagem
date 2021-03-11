<?php

namespace Modelagem\Model;

final class Ocorrencia extends Model
{
    public string $assunto;
    public int $id_usuario;
    public string $plano_acao;
    public bool $ativo;
    public int $id_turma;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->assunto = $obj['assunto'];
        $this->id_usuario = $obj['id_usuario'];
        $this->plano_acao = $obj['plano_acao'];
        $this->ativo = $obj['ativo'];
        $this->id_turma = $obj['id_turma'];
        return parent::init($obj);
    }
}
