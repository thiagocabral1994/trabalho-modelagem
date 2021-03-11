<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Status;

final class StatusDAO extends DAO
{
    const INSERT_SQL = 
    'INSERT INTO status (nome) VALUES (
        :nome
    );';

    const UPDATE_SQL = 'UPDATE status SET
        nome = :nome
    WHERE id = :id;';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct('status', self::INSERT_SQL, self::UPDATE_SQL, );
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Status) {
            $stmt->bindParam('nome', $obj->nome, \PDO::PARAM_STR);
        }
    }
}

