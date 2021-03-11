<?php

namespace Modelagem\Model;

final class Usuario extends Model
{
    public string $cpf;
    public string $rg;
    public string $nome;
    public string $email;
    public string $cep;
    public int $numero;
    public string $complemento;
    public string $bairro;
    public string $estado;
    public string $pais;
    public string $cidade;
    public string $telefone;
    public string $logradouro;
    public ?string $senha;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
    }

    public function init(array $obj): Model
    {
        $this->cpf = $obj['cpf'];
        $this->rg = $obj['rg'];
        $this->nome = $obj['nome'];
        $this->email = $obj['email'];
        $this->cep = $obj['cep'];
        $this->logradouro = $obj['logradouro'];
        $this->numero = $obj['numero'];
        $this->complemento = $obj['complemento'];
        $this->bairro = $obj['bairro'];
        $this->estado = $obj['estado'];
        $this->cidade = $obj['cidade'];
        $this->pais = $obj['pais'];
        $this->telefone = $obj['telefone'];
        $this->senha = $obj['senha'];
        if (isset($obj['grupos'])) {
            $this->grupos = $obj['grupos'];
        }
        return parent::init($obj);
    }
}
