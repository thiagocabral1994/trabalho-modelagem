<?php

namespace Modelagem\Logic;

use Modelagem\DAO\GrupoDAO;
use Modelagem\DAO\PermissaoDAO;
use Modelagem\DAO\UsuarioDAO;
use Modelagem\Model\Usuario;

class UsuarioLogic
{
    public static function get(int $id): ?Usuario
    {
        $dao = new UsuarioDAO();
        $usuario = $dao->get($id);
        if (isset($usuario)) {
            unset($usuario->senha);
            $permissaoDAO = new PermissaoDAO();
            $usuario->permissoes = $permissaoDAO->listByUser($id);
            $grupoDAO = new GrupoDAO();
            $usuario->grupos = $grupoDAO->listByUser($id);
        }
        return $usuario;
    }

    public static function list(): array
    {
        $dao = new UsuarioDAO();
        return $dao->listWithoutPass();
    }

    public static function save(Usuario $u): bool
    {
        $dao = new UsuarioDAO();
        if (isset($u->senha)) {
            $u->senha = md5($u->senha);
        }
        if (!$dao->save($u)) {
            return false;
        }
        $dao->joinGroups($u->id, $u->grupos ?? []);
        return true;
    }

    public static function delete(int $id): bool
    {
        $dao = new UsuarioDAO();

        if (!$dao->exists($id)) {
            return false;
        }
        return $dao->delete($id);
    }
}
