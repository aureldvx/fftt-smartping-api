<?php

declare(strict_types=1);

namespace SmartpingApi\Service;

use SmartpingApi\Contract\EpreuveContract;
use SmartpingApi\Core\HttpClientContract;
use SmartpingApi\Enum\API;
use SmartpingApi\Enum\TypeEpreuve;
use SmartpingApi\Model\Epreuve\Division;
use SmartpingApi\Model\Epreuve\Epreuve;

final readonly class EpreuveService implements EpreuveContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function rechercherEpreuves(int $organizationId, TypeEpreuve $contestType): array
    {
        $response = $this->httpClient->fetch(API::XML_EPREUVE, [
            'organisme' => $organizationId,
            'type' => $contestType->value,
        ]);

        return array_map(fn($item) => Epreuve::fromArray($item), $response['epreuve'] ?? []);
    }

    /** @inheritdoc */
    public function rechercherDivisionsPourEpreuve(int $organizationId, int $contestId, TypeEpreuve $contestType): array
    {
        $response = $this->httpClient->fetch(API::XML_DIVISION, [
            'organisme' => $organizationId,
            'epreuve' => $contestId,
            'type' => $contestType->value,
        ]);

        return array_map(fn($item) => Division::fromArray($item), $response['division'] ?? []);
    }
}
