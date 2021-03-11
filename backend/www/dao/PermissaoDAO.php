<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Permissao;

final class PermissaoDAO extends DAO
{
    const TABLE = 'permissao';

    const INSERT_SQL =
    'INSERT INTO ' . self::TABLE . '(nome, descricao) VALUES (
            :nome,
            :descricao
        );';

    const UPDATE_SQL =
    'UPDATE ' . self::TABLE . 'SET
            nome = :nome,
            descricao = :descricao
        WHERE id = :id';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct(self::TABLE, self::INSERT_SQL, self::UPDATE_SQL, $pdo);
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Permissao) {
            $stmt->bindParam('nome', $obj->nome, \PDO::PARAM_STR);
            $stmt->bindParam('descricao', $obj->descricao, \PDO::PARAM_STR);
        }
    }

    public function listByUser(int $user_id): array
    {
        $query =
            'SELECT permissao.* FROM grupo_usuario 
                INNER JOIN grupo ON grupo.id = grupo_usuario.id_grupo
                INNER JOIN permissao_grupo ON permissao_grupo.id_grupo = grupo.id
                INNER JOIN permissao ON permissao.id = permissao_grupo.id_permissao
            WHERE grupo_usuario.id_usuario = :id_usuario';
        $bind = function (\PDOStatement $stmt) use ($user_id) {
            $stmt->bindParam('id_usuario', $user_id, \PDO::PARAM_INT);
        };
        return $this->fetch($query, $bind);
    }

    public function listByGroup(int $group_id): array
    {
        $query =
            'SELECT permissao.* FROM permissao_grupo
                INNER JOIN permissao ON permissao.id = permissao_grupo.id_permissao
            WHERE permissao_grupo.id_grupo = :id_grupo';
        $bind = function (\PDOStatement $stmt) use ($group_id) {
            $stmt->bindParam('id_grupo', $group_id, \PDO::PARAM_INT);
        };
        return $this->fetch($query, $bind);
    }

    public function givePermissions(int $group_id, array $permissions)
    {
        $stmt = $this->getPDO()->prepare(
            'DELETE FROM permissao_grupo WHERE id_grupo = :id_grupo'
        );
        $stmt->bindParam('id_grupo', $group_id, \PDO::PARAM_INT);
        $stmt->execute();
        foreach ($permissions as $permission_id) {
            $query = 'INSERT INTO permissao_grupo(id_grupo, id_permissao) VALUES(
                :id_grupo,
                :id_permissao
            );';
            $stmt = $this->getPDO()->prepare($query);
            $stmt->bindParam('id_grupo', $group_id, \PDO::PARAM_INT);
            $stmt->bindParam('id_permissao', $permission_id, \PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}
