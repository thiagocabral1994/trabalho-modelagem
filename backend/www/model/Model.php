<?php

namespace Modelagem\Model;

abstract class Model
{
    public int $id;

    protected function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    public function init(array $obj): Model
    {
        $this->id = $obj['id'] ?? 0;
        return $this;
    }
}
