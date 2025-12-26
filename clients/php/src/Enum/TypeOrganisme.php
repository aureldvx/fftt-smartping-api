<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum TypeOrganisme: string
{
    case FEDERATION = 'F';
    case ZONE = 'Z';
    case LIGUE = 'L';
    case COMITE = 'D';
}
