<?php

namespace Modelagem\Logic;

use Modelagem\Model\Atividade;
use Modelagem\DAO\AtividadeDAO;

final class AtividadeLogic
{
    public static function get(int $id): ?Atividade
    {
        $dao = new AtividadeDAO();
        return $dao->get($id);
    }

    public static function list(): array
    {
        $dao = new AtividadeDAO();
        return $dao->list();
    }

    public static function listByClass(int $idClass): array
    {
        $dao = new AtividadeDAO();
        return $dao->listByClass($idClass);
    }

    public static function save(Atividade $atividade): bool
    {
        $dao = new AtividadeDAO();
        return $dao->save($atividade);
    }

    public static function delete(int $id): bool
    {
        $dao = new AtividadeDAO();
        return $dao->delete($id);
    }
}

