<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Atividade;

final class AtividadeDAO extends DAO
{
    const INSERT_SQL =
    'INSERT INTO atividade (titulo, descricao, anexo, id_turma) VALUES (
        :titulo,
        :descricao,
        :anexo,
        :id_turma
    );';

    const UPDATE_SQL = 'UPDATE atividade SET
        titulo = :titulo,
        descricao = :descricao,
        anexo = :anexo,
        id_turma = :id_turma
    WHERE id = :id;';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct('atividade', self::INSERT_SQL, self::UPDATE_SQL,);
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Atividade) {
            $stmt->bindParam('titulo', $obj->titulo, \PDO::PARAM_STR);
            $stmt->bindParam('descricao', $obj->descricao, \PDO::PARAM_STR);
            $stmt->bindParam('anexo', $obj->anexo, \PDO::PARAM_STR);
            $stmt->bindParam('id_turma', $obj->id_turma, \PDO::PARAM_INT);
        }
    }

    public function listByClass($id_turma): array
    {
        $sql = 'SELECT * FROM atividade WHERE id_turma = :id_turma;';
        $stmt = $this->getPDO()->prepare($sql);
        $stmt->bindParam('id_turma', $id_turma, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
