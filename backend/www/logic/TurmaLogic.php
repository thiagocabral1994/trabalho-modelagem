<?php

namespace Modelagem\Logic;

use Modelagem\Model\Turma;
use Modelagem\DAO\TurmaDAO;

final class TurmaLogic
{
    public static function get(int $id): ?Turma
    {
        $dao = new TurmaDAO();
        return $dao->get($id);
    }

    public static function list(): array
    {
        $dao = new TurmaDAO();
        return $dao->list();
    }

    public static function save(Turma $turma): bool
    {
        $dao = new TurmaDAO();
        return $dao->save($turma);
    }

    public static function delete(int $id): bool
    {
        $dao = new TurmaDAO();
        return $dao->delete($id);
    }
}

