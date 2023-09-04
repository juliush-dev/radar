<?php

namespace App\Assets;


class KnowHowId extends ValueObject
{
    function __construct(private String $id)
    {
    }
    public function getEqualityComponents(): array
    {
        return [$this->id];
    }
}
