<?php

declare(strict_types=1);

namespace SmartpingApi\Service;

use SmartpingApi\Contract\OrganismeContract;
use SmartpingApi\Core\HttpClientContract;
use SmartpingApi\Enum\API;
use SmartpingApi\Enum\TypeOrganisme;
use SmartpingApi\Model\Organisme\Organisme;

final class OrganismeService implements OrganismeContract
{
    /**
     * @var array<array-key, Organisme> Store de l'ensemble des organismes,
     * nécessaire puisque l'API ne propose aucun endpoint pour en récupérer
     * une facilement par son identifiant.
     */
    private array $organismes = [];

    public function __construct(private readonly HttpClientContract $httpClient)
    {
        $this->remplirOrganismes();
    }

    /** @inheritdoc */
    public function organismesParType(TypeOrganisme $orgType): array
    {
        return array_values(array_filter(
            $this->organismes,
            fn (Organisme $org) => $org->type() === $orgType
        ));
    }

    /** @inheritdoc */
    public function organisme(string $code): ?Organisme
    {
        return array_find($this->organismes, fn (Organisme $org) => $org->code() === $code);
    }

    /** @inheritdoc */
    public function organismesEnfants(string $code): array
    {
        $parentId = $this->organisme($code)?->id();

        if ($parentId === null) {
            return [];
        }

        return array_values(array_filter(
            $this->organismes,
            fn (Organisme $org) => $org->idOrganismeParent() === $parentId
        ));
    }

    private function remplirOrganismes(): void
    {
        if (count($this->organismes) > 0) {
            return;
        }

        $orgTypes = TypeOrganisme::cases();

        $fetch = function (TypeOrganisme $orgType): array {
            $response = $this->httpClient->fetch(API::XML_ORGANISME, ['type' => $orgType->value]);

            if (array_key_exists('id', $response['organisme'])) {
                return [Organisme::fromArray($response['organisme'])];
            }

            return array_map(fn ($org) => Organisme::fromArray($org), $response['organisme'] ?? []);
        };

        foreach ($orgTypes as $type) {
            $this->organismes = array_merge($this->organismes, $fetch($type));
        }
    }
}
