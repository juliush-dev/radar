<?php

namespace App\Assets;


class SkillId extends ValueObject
{
    function __construct(private String $id)
    {
    }
    public function getEqualityComponents(): array
    {
        return [$this->id];
    }
}
