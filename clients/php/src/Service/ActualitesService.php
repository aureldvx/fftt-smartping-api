<?php

declare(strict_types=1);

namespace SmartpingApi\Service;

use SmartpingApi\Contract\ActualitesContract;
use SmartpingApi\Core\HttpClientContract;
use SmartpingApi\Enum\API;
use SmartpingApi\Model\Divers\Actualite;

final readonly class ActualitesService implements ActualitesContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function fluxActualitesFederation(): array
    {
        $response = $this->httpClient->fetch(API::XML_NEW_ACTU, []);

        return array_map(fn ($item) => Actualite::fromArray($item), $response['news']);
    }
}
