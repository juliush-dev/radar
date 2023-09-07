<?php

namespace App\Enums;


enum ModificationType: string
{
    case Create = 'create';
    case Update = 'update';
    case Delete = 'delete';
}
