<?php

namespace App\Enums;


enum YearLevel: int
{
    case First = 1;
    case Second = 2;
    case Third = 3;

    public static function asOptions()
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };

        $yearsLevels = self::cases();
        $yearsLevelsOptions = array_column($yearsLevels, 'value');
        $yearsLevelsOptions = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);
        return $yearsLevelsOptions;
    }
}
