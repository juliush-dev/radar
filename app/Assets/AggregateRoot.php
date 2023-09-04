<?php

namespace App\Assets;


abstract class AggregateRoot extends Entity
{
    protected function __construct(ValueObject $id)
    {
        parent::__construct($id);
    }

    public function getId(): ValueObject
    {
        return clone $this->id;
    }
}
