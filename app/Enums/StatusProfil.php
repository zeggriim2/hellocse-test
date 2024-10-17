<?php

declare(strict_types=1);

namespace App\Enums;

enum StatusProfil : string
{
    case INACTIF = 'inactif';
    case ATTENTE = 'attente';
    case ACTIF   = 'actif';
}
