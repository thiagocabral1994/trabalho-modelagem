<?php

namespace Modelagem\Logic;

use Modelagem\Model\Curso;
use Modelagem\DAO\CursoDAO;

final class CursoLogic
{
    public static function get(int $id): ?Curso
    {
        $dao = new CursoDAO();
        return $dao->get($id);
    }

    public static function list(): array
    {
        $dao = new CursoDAO();
        return $dao->list();
    }

    public static function save(Curso $curso): bool
    {
        $dao = new CursoDAO();
        return $dao->save($curso);
    }

    public static function delete(int $id): bool
    {
        $dao = new CursoDAO();
        return $dao->delete($id);
    }
}

