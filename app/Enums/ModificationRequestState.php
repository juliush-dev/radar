<?php

namespace App\Enums;


enum ModificationRequestState: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
