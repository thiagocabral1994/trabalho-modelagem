<?php

namespace Modelagem\Logic;

use Modelagem\Model\Status;
use Modelagem\DAO\StatusDAO;

final class StatusLogic
{
    public static function get(int $id): ?Status
    {
        $dao = new StatusDAO();
        return $dao->get($id);
    }

    public static function list(): array
    {
        $dao = new StatusDAO();
        return $dao->list();
    }

    public static function save(Status $status): bool
    {
        $dao = new StatusDAO();
        return $dao->save($status);
    }

    public static function delete(int $id): bool
    {
        $dao = new StatusDAO();
        return $dao->delete($id);
    }
}

