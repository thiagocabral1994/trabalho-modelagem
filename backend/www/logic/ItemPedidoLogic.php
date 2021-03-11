<?php

namespace Modelagem\Logic;

use Modelagem\Model\ItemPedido;
use Modelagem\DAO\DAO;
use Modelagem\DAO\ItemPedidoDAO;

final class ItemPedidoLogic
{
    public static function get(int $id): ?ItemPedido
    {
        $dao = new ItemPedidoDAO();
        return $dao->get($id);
    }

    public static function list(): array
    {
        $dao = new ItemPedidoDAO();
        return $dao->list();
    }

    public static function listByPedido(int $idPedido): array
    {
        $dao = new ItemPedidoDAO();
        return $dao->listByPedido($idPedido);
    }

    public static function save(ItemPedido $itemPedido): bool
    {
        $dao = new ItemPedidoDAO();
        return $dao->save($itemPedido);
    }

    public static function saveList(array $list): bool
    {
        $pdo = DAO::createConnection();
        try {
            $dao = new ItemPedidoDAO($pdo);
            $pdo->beginTransaction();
            if (!$dao->saveList($list)) {
                $pdo->rollBack();
                return false;
            }
            $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
        return true;
    }

    public static function delete(int $id): bool
    {
        $dao = new ItemPedidoDAO();
        return $dao->delete($id);
    }
}

