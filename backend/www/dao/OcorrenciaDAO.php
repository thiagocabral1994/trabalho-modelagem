<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Ocorrencia;

final class OcorrenciaDAO extends DAO
{
    const INSERT_SQL = 
    'INSERT INTO ocorrencia (assunto, id_usuario, plano_acao, ativo, id_turma) VALUES (
        :assunto,
        :id_usuario,
        :plano_acao,
        :ativo,
        :id_turma
    );';

    const UPDATE_SQL = 'UPDATE ocorrencia SET
        assunto = :assunto,
        id_usuario = :id_usuario,
        plano_acao = :plano_acao,
        ativo = :ativo,
        id_turma = :id_turma
    WHERE id = :id;';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct('ocorrencia', self::INSERT_SQL, self::UPDATE_SQL, );
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Ocorrencia) {
            $stmt->bindParam('assunto', $obj->assunto, \PDO::PARAM_STR);
            $stmt->bindParam('id_usuario', $obj->id_usuario, \PDO::PARAM_INT);
            $stmt->bindParam('plano_acao', $obj->plano_acao, \PDO::PARAM_STR);
            $stmt->bindParam('ativo', $obj->ativo, \PDO::PARAM_BOOL);
            $stmt->bindParam('id_turma', $obj->id_turma, \PDO::PARAM_INT);
        }
    }
}

