<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Turma;

final class TurmaDAO extends DAO
{
    const INSERT_SQL = 
    'INSERT INTO turma (quantidade_alunos, id_usuario, id_status, ativo, id_curso) VALUES (
        :quantidade_alunos,
        :id_usuario,
        :id_status,
        :ativo,
        :id_curso
    );';

    const UPDATE_SQL = 'UPDATE turma SET
        quantidade_alunos = :quantidade_alunos,
        id_usuario = :id_usuario,
        id_status = :id_status,
        ativo = :ativo,
        id_curso = :id_curso
    WHERE id = :id;';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct('turma', self::INSERT_SQL, self::UPDATE_SQL, );
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Turma) {
            $stmt->bindParam('quantidade_alunos', $obj->quantidade_alunos, \PDO::PARAM_INT);
            $stmt->bindParam('id_usuario', $obj->id_usuario, \PDO::PARAM_INT);
            $stmt->bindParam('id_status', $obj->id_status, \PDO::PARAM_INT);
            $stmt->bindParam('ativo', $obj->ativo, \PDO::PARAM_BOOL);
            $stmt->bindParam('id_curso', $obj->id_curso, \PDO::PARAM_INT);
        }
    }
}

