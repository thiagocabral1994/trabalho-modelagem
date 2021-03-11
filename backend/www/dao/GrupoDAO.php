<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Grupo;

final class GrupoDAO extends DAO
{
    const INSERT_SQL =
    'INSERT INTO grupo (nome, descricao) VALUES (
        :nome,
        :descricao
    );';

    const UPDATE_SQL = 'UPDATE grupo SET
        nome = :nome,
        descricao = :descricao
    WHERE id = :id;';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct('grupo', self::INSERT_SQL, self::UPDATE_SQL);
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Grupo) {
            $stmt->bindParam('nome', $obj->nome, \PDO::PARAM_STR);
            $stmt->bindParam('descricao', $obj->descricao, \PDO::PARAM_STR);
        }
    }

    public function listByUser(int $user_id): array
    {
        $query =
            'SELECT grupo.* FROM grupo_usuario
            INNER JOIN grupo ON grupo.id = grupo_usuario.id_grupo
            WHERE grupo_usuario.id_usuario = :id_usuario';
        $bind = function (\PDOStatement $stmt) use ($user_id) {
            $stmt->bindParam('id_usuario', $user_id, \PDO::PARAM_INT);
        };
        return $this->fetch($query, $bind);
    }

    public function addUsersToGroup(array $users, int $group_id)
    {
        $this->getPDO()->exec(
            "DELETE FROM grupo_usuario WHERE id_grupo = $group_id"
        );
        if (empty($users)) {
            return;
        }
        $query =
            'INSERT INTO grupo_usuario(id_grupo, id_usuario) VALUES';
        foreach ($users as $user_id) {
            $query = $query . "($group_id, $user_id),";
        }
        $query = substr($query, 0, -1);
        $this->getPDO()->exec($query);
    }
}
