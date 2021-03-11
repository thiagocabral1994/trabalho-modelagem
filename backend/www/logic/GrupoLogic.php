<?php

namespace Modelagem\Logic;

use Modelagem\Model\Grupo;
use Modelagem\DAO\GrupoDAO;
use Modelagem\DAO\PermissaoDAO;
use Modelagem\DAO\UsuarioDAO;

final class GrupoLogic
{
    public static function get(int $id): ?Grupo
    {
        $dao = new GrupoDAO();
        $model = $dao->get($id);
        if (isset($model)) {
            $permissaoDAO = new PermissaoDAO();
            $model->permissoes = $permissaoDAO->listByGroup($id);
            $usuarioDAO = new UsuarioDAO();
            $model->usuarios = $usuarioDAO->listByGroup($id);
        }
        return $model;
    }

    public static function list(): array
    {
        $dao = new GrupoDAO();
        return $dao->list();
    }

    public static function save(Grupo $grupo): bool
    {
        $dao = new GrupoDAO();
        if (!$dao->save($grupo)) {
            return false;
        }
        echo "<pre>";
        var_dump($grupo);
        $permissaoDAO = new PermissaoDAO();
        $permissaoDAO->givePermissions($grupo->id, $grupo->permissoes);
        $dao->addUsersToGroup($grupo->usuarios ?? [], $grupo->id);
        return true;
    }

    public static function delete(int $id): bool
    {
        $dao = new GrupoDAO();
        return $dao->delete($id);
    }
}
