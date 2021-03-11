<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Token;

class TokenDAO extends DAO
{
    const TABLE = 'token';

    const INSERT_SQL =
    'INSERT INTO ' . self::TABLE . '(jwt, refresh_token, id_usuario) VALUES(
            :jwt,
            :refresh_token,
            :id_usuario
        );';

    const UPDATE_SQL =
    'UPDATE ' . self::TABLE . ' SET
            jwt = :jwt,
			refresh_token = :refresh_token,
            id_usuario = :id_usuario,
        WHERE id = :id';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct(self::TABLE, self::INSERT_SQL, self::UPDATE_SQL, $pdo);
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Token) {
            $stmt->bindParam('jwt', $obj->jwt, \PDO::PARAM_STR);
            $stmt->bindParam('refresh_token', $obj->refresh_token, \PDO::PARAM_STR);
            $stmt->bindParam('id_usuario', $obj->id_usuario, \PDO::PARAM_INT);
        }
    }
}
