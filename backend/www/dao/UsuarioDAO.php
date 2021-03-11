<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\Usuario;

final class UsuarioDAO extends DAO
{
    const TABLE = 'usuario';

    const INSERT_SQL =
    'INSERT INTO ' . self::TABLE . '(cpf, rg, nome, email, cep, logradouro, numero, complemento, bairro, estado, cidade, pais, telefone, senha) VALUES(
			:cpf,
			:rg,
            :nome,
			:email,
			:cep,
			:logradouro,
			:numero,
			:complemento,
			:bairro,
            :estado,
            :cidade,
            :pais,
            :telefone,
            :senha
        );';

    const UPDATE_SQL =
    'UPDATE ' . self::TABLE . ' SET
            cpf     = :cpf,
            rg     = :rg,
            nome    = :nome,
			email   = :email,
            cep     = :cep,
            logradouro     = :logradouro,
            numero     = :numero,
            complemento     = :complemento,
            bairro     = :bairro,
            estado     = :estado,
            cidade     = :cidade,
            pais     = :pais,
            telefone     = :telefone,
            senha   = :senha
        WHERE id = :id';

    const UPDATE_SQL_SEM_SENHA =
    'UPDATE ' . self::TABLE . ' SET
        cpf     = :cpf,
        rg     = :rg,
        nome    = :nome,
        email   = :email,
        cep     = :cep,
        logradouro     = :logradouro,
        numero     = :numero,
        complemento     = :complemento,
        bairro     = :bairro,
        estado     = :estado,
        cidade     = :cidade,
        pais     = :pais,
        telefone     = :telefone,
            WHERE id = :id';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct(self::TABLE, self::INSERT_SQL, self::UPDATE_SQL, $pdo);
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof Usuario) {
            $stmt->bindParam('cpf', $obj->cpf, \PDO::PARAM_STR);
            $stmt->bindParam('rg', $obj->rg, \PDO::PARAM_STR);
            $stmt->bindParam('nome', $obj->nome, \PDO::PARAM_STR);
            $stmt->bindParam('email', $obj->email, \PDO::PARAM_STR);
            $stmt->bindParam('cep', $obj->ceo, \PDO::PARAM_STR);
            $stmt->bindParam('logradouro', $obj->logradouro, \PDO::PARAM_STR);
            $stmt->bindParam('numero', $obj->numero, \PDO::PARAM_INT);
            $stmt->bindParam('complemento', $obj->complemento, \PDO::PARAM_STR);
            $stmt->bindParam('bairro', $obj->bairro, \PDO::PARAM_STR);
            $stmt->bindParam('estado', $obj->estado, \PDO::PARAM_STR);
            $stmt->bindParam('cidade', $obj->cidade, \PDO::PARAM_STR);
            $stmt->bindParam('pais', $obj->pais, \PDO::PARAM_STR);
            if (isset($obj->senha)) {
                $stmt->bindParam('senha', $obj->senha, \PDO::PARAM_STR);
            }
        }
    }

    public function getByCpf(string $cpf): ?Usuario
    {
        $statement = 'SELECT * FROM usuario WHERE cpf = :cpf';
        $bind = function ($stmt) use ($cpf) {
            $stmt->bindParam('cpf', $cpf, \PDO::PARAM_STR);
        };
        return parent::_getBy($statement, $bind);
    }

    public function insertWithPermissions(Usuario $user, array $permissions = null): bool
    {
        if ($this->insert($user) && isset($permissions)) {
            $permissionDAO = new PermissaoDAO();
            $permissionDAO->givePermissions($user->id, $permissions);
        }
        return false;
    }

    public function save(Model $obj): bool
    {
        if ($obj->id == 0) {
            return $this->insert($obj);
        }
        if (isset($obj->senha)) {
            return $this->update($obj);
        }
        return $this->update($obj, self::UPDATE_SQL_SEM_SENHA);
    }

    public function saveWithPermissions(Usuario $user, array $permissions = null): bool
    {
        if ($this->save($user) && isset($permissions)) {
            $permissionDAO = new PermissaoDAO();
            $permissionDAO->givePermissions($user->id, $permissions);
        }
        return false;
    }

    public function listByGroup(int $group_id): array
    {
        $query =
            'SELECT
                usuario.id,
                usuario.cpf,
			    usuario.rg,
                usuario.nome,
			    usuario.email,
			    usuario.cep,
			    usuario.logradouro,
			    usuario.numero,
			    usuario.complemento,
			    usuario.bairro,
                usuario.estado,
                usuario.cidade,
                usuario.pais,
                usuario.telefone
            FROM grupo_usuario
            INNER JOIN usuario ON usuario.id = grupo_usuario.id_usuario
            WHERE grupo_usuario.id_grupo = :id_grupo';
        $bind = function (\PDOStatement $stmt) use ($group_id) {
            $stmt->bindParam('id_grupo', $group_id, \PDO::PARAM_INT);
        };
        return $this->fetch($query, $bind);
    }

    public function listWithoutPass(): array
    {
        return parent::fetch(
            'SELECT 
                id,
                cpf,
			    rg,
                nome,
			    email,
			    cep,
			    logradouro,
			    numero,
			    complemento,
			    bairro,
                estado,
                cidade,
                pais,
                telefone
             FROM ' . self::TABLE
        );
    }

    public function listBySector(int $sector_id): array
    {
        $query =
            'SELECT usuario.* FROM setor_usuario
             INNER JOIN usuario ON usuario.id = setor_usuario.id_usuario
             WHERE setor_usuario.id_setor = :id_setor';
        $bind = function (\PDOStatement $stmt) use ($sector_id) {
            $stmt->bindParam('id_setor', $sector_id, \PDO::PARAM_INT);
        };
        return $this->fetch($query, $bind);
    }

    public function joinSectors(int $user_id, array $sectors)
    {
        $this->getPDO()->exec(
            "DELETE FROM setor_usuario WHERE id_usuario = $user_id"
        );
        if (empty($sectors)) {
            return;
        }
        $query =
            'INSERT INTO setor_usuario(id_setor, id_usuario) VALUES';
        foreach ($sectors as $sector_id) {
            $query = $query . "($sector_id, $user_id),";
        }
        $query = substr($query, 0, -1);
        $this->getPDO()->exec($query);
    }

    public function joinGroups(int $user_id, array $groups)
    {
        $this->getPDO()->exec(
            "DELETE FROM grupo_usuario WHERE id_usuario = $user_id"
        );
        if (empty($groups)) {
            return;
        }
        $query =
            'INSERT INTO grupo_usuario(id_usuario, id_grupo) VALUES';
        foreach ($groups as $grupo_id) {
            $query = $query . "($user_id, $grupo_id),";
        }
        $query = substr($query, 0, -1);
        $this->getPDO()->exec($query);
    }
}
