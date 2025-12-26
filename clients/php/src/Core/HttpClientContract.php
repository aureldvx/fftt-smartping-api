<?php

declare(strict_types=1);

namespace SmartpingApi\Core;

use SmartpingApi\Enum\API;

interface HttpClientContract
{
    /**
     * Appelle un endpoint et le convertit en tableau associatif.
     */
    function fetch(API $endpoint, array $requestParams): array;
}
