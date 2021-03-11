<?php

namespace Modelagem\Logic;

use Modelagem\Model\Permissao;
use Modelagem\DAO\PermissaoDAO;

class PermissaoLogic
{
    public static function get(int $id): ?Permissao
    {
        $dao = new PermissaoDAO();
        return $dao->get($id);
    }

    public static function list(): array
    {
        $dao = new PermissaoDAO();
        return $dao->list();
    }

    public static function save(Permissao $u): bool
    {
        $dao = new PermissaoDAO();
        return $dao->save($u);
    }

    public static function delete(int $id): bool
    {
        $dao = new PermissaoDAO();

        if (!$dao->exists($id)) {
            return false;
        }
        return $dao->delete($id);
    }
}
