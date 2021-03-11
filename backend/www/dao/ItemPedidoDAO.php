<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;
use Modelagem\Model\ItemPedido;

final class ItemPedidoDAO extends DAO
{
    const INSERT_SQL = 
    'INSERT INTO item_pedido (id_pedido, id_produto, justificativa, prioridade, quantidade, quantidade_autorizada, observacao) VALUES (
        :id_pedido,
        :id_produto,
        :justificativa,
        :prioridade,
        :quantidade,
        :quantidade_autorizada,
        :observacao
    );';

    const UPDATE_SQL = 'UPDATE item_pedido SET
        id_pedido = :id_pedido,
        id_produto = :id_produto,
        justificativa = :justificativa,
        prioridade = :prioridade,
        quantidade = :quantidade,
        quantidade_autorizada = :quantidade_autorizada,
        observacao = :observacao
    WHERE id = :id;';

    const SELECT_SQL = 'SELECT ip.*, (
                SELECT COUNT(1) 
                FROM orcamento o 
                WHERE o.id_item_pedido = ip.id
            ) num_orcamentos 
        FROM item_pedido ip';

    public function __construct(\PDO $pdo = null)
    {
        parent::__construct('item_pedido', self::INSERT_SQL, self::UPDATE_SQL, );
    }

    protected function bindParam(\PDOStatement $stmt, Model $obj)
    {
        if ($obj instanceof ItemPedido) {
            $stmt->bindParam('id_pedido', $obj->id_pedido, \PDO::PARAM_INT);
            $stmt->bindParam('id_produto', $obj->id_produto, \PDO::PARAM_INT);
            $stmt->bindParam('justificativa', $obj->justificativa, \PDO::PARAM_STR);
            $stmt->bindParam('prioridade', $obj->prioridade, \PDO::PARAM_INT);
            $stmt->bindParam('quantidade', $obj->quantidade, \PDO::PARAM_STR);
            $stmt->bindParam('quantidade_autorizada', $obj->quantidade_autorizada, \PDO::PARAM_STR);
            $stmt->bindParam('observacao', $obj->observacao, \PDO::PARAM_STR);
        }
    }

    public function listByPedido($id_pedido): array
    {
        $sql = self::SELECT_SQL . ' WHERE id_pedido = :id_pedido;';
        $stmt = $this->getPDO()->prepare($sql);
        $stmt->bindParam('id_pedido', $id_pedido, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function saveList(array $list): bool
    {
        $id_pedido = intval($list[0]->id_pedido);
        $sql = 'DELETE FROM item_pedido WHERE id_pedido = ' . $id_pedido;
        $stmt = $this->getPDO()->prepare($sql);
        if (!$stmt->execute()) {
            return false;
        }
        foreach ($list as $item) {
            $item->id_pedido = $id_pedido;
            if (!$this->save($item)) {
                return false;
            }
        }
        return true;
    }
}
