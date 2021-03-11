<?php

namespace Modelagem\Model;

final class ItemPedido extends Model
{
    public int $id_pedido;
    public int $id_produto;
    public string $justificativa;
    public int $prioridade;
    public float $quantidade;
    public ?float $quantidade_autorizada;
    public ?string $observacao;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->id_pedido = $obj['id_pedido'] ?? 0;
        $this->id_produto = $obj['id_produto'];
        $this->justificativa = $obj['justificativa'];
        $this->prioridade = $obj['prioridade'];
        $this->quantidade = $obj['quantidade'];
        $this->quantidade_autorizada = $obj['quantidade_autorizada'];
        $this->observacao = $obj['observacao'];
        return parent::init($obj);
    }
}
