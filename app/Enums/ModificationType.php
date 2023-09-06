<?php

namespace App\Enums;


enum ModificationType: string
{
    case CreateAndMakePublic = 'create and make public';
    case CreateAndMakePrivate = 'create and make private';
    case MakePrivate = 'make private';
    case MakePublic = 'make public';
    case Update = 'update';
    case Delete = 'delete';
}
