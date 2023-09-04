<?php

namespace App\Enums;


enum Visibility: string
{
    case Public = 'public';
    case Private = 'private';
    case Disabled = 'disabled';
}
