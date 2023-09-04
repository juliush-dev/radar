<?php

namespace App\Assets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


abstract class Entity extends Model
{
    use HasFactory;
    protected function __construct(protected ValueObject $id)
    {
    }

    public function getId()
    {
        return clone $this->id;
    }

    public function equal(Entity $anotherEntity): bool
    {
        if ($anotherEntity == null || !$anotherEntity instanceof static) {
            return false;
        }
        return $this->id == $anotherEntity->id;
    }
}
