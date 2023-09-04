<?php

namespace App\Assets;

abstract class ValueObject
{

    public abstract function getEqualityComponents(): array;

    public function equal(ValueObject $anotherValueObject): bool
    {
        if ($anotherValueObject == null || !$anotherValueObject instanceof static) {
            return false;
        }
        return empty(array_diff(
            $this->getEqualityComponents(),
            $anotherValueObject->getEqualityComponents(),
        ));
    }
}
