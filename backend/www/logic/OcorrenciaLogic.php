<?php

namespace Modelagem\Logic;

use Modelagem\Model\Ocorrencia;
use Modelagem\DAO\OcorrenciaDAO;

final class OcorrenciaLogic
{
    public static function get(int $id): ?Ocorrencia
    {
        $dao = new OcorrenciaDAO();
        return $dao->get($id);
    }

    public static function list(): array
    {
        $dao = new OcorrenciaDAO();
        return $dao->list();
    }

    public static function save(Ocorrencia $ocorrencia): bool
    {
        $dao = new OcorrenciaDAO();
        return $dao->save($ocorrencia);
    }

    public static function delete(int $id): bool
    {
        $dao = new OcorrenciaDAO();
        return $dao->delete($id);
    }
}

