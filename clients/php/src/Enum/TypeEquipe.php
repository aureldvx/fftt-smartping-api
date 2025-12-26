<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum TypeEquipe: string
{
    case MASCULINE = 'M';
    case FEMININE = 'F';
    case MIXTE = 'A';
    case AUTRE = '';
}
