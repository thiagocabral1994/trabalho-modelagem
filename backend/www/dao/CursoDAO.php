<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Curso;

final class CursoDAO extends DAO
{
    const INSERT_SQL = 
    'INSERT INTO curso (nome, descricao, duracao, ementa, ativo) VALUES (
        :nome,
        :descricao,
        :duracao,
        :ementa,
        :ativo
    );';

    const UPDATE_SQL = 'UPDATE curso SET
        nome = :nome,
        descricao = :descricao,
        duracao = :duracao,
        ementa = :ementa,
        ativo = :ativo
    WHERE id = :id;';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct('curso', self::INSERT_SQL, self::UPDATE_SQL, );
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Curso) {
            $stmt->bindParam('nome', $obj->nome, \PDO::PARAM_STR);
            $stmt->bindParam('descricao', $obj->descricao, \PDO::PARAM_STR);
            $stmt->bindParam('duracao', $obj->duracao, \PDO::PARAM_INT);
            $stmt->bindParam('ementa', $obj->ementa, \PDO::PARAM_STR);
            $stmt->bindParam('ativo', $obj->ativo, \PDO::PARAM_BOOL);
        }
    }
}

