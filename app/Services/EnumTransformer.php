<?php

namespace App\Services;


class EnumTransformer
{
    public function asOptions($enum)
    {
        return collect($enum::cases())->reduce(function ($acc, $item) {
            array_push(
                $acc,
                [
                    'id' => $item->value,
                    'label' => ucfirst($item->value),
                ]
            );
            return $acc;
        }, []);
    }
}
