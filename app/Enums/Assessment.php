<?php

namespace App\Enums;


enum Assessment: string
{
    case Bad = 'bad';
    case Scared = 'scared';
    case Hesitant = 'hesitant';
    case Confident = 'confident';
    case Flawless = 'flawless';
}
