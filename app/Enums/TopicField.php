<?php

namespace App\Enums;


enum TopicField: string
{
    case Field_1 = 'field_1';
    case Field_2 = 'field_2';
    case Field_3 = 'field_3';

    public static function asOptions()
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };

        $topicFields = self::cases();
        $topicFieldsOptions = array_column($topicFields, 'value');
        $topicFieldsOptionsPair = array_reduce($topicFieldsOptions, $getKeyValuePair, []);
        return $topicFieldsOptionsPair;
    }
}
