<?php

namespace App\Enums;


enum TopicGroup: string
{
    case Group_1 = 'group_1';
    case Group_2 = 'group_2';
    case Group_3 = 'group_3';

    public static function asOptions()
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };

        $topicGroups = self::cases();
        $topicGroupsOptions = array_column($topicGroups, 'value');
        $topicGroupsOptionsPair = array_reduce($topicGroupsOptions, $getKeyValuePair, []);
        return $topicGroupsOptionsPair;
    }
}
