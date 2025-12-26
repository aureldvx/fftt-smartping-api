<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum Sexe: string
{
    case HOMME = 'M';
    case FEMME = 'F';
    case AUTRE = '';
}
