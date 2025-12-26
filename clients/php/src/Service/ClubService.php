<?php

declare(strict_types=1);

namespace SmartpingApi\Service;

use SmartpingApi\Contract\ClubContract;
use SmartpingApi\Core\HttpClientContract;
use SmartpingApi\Enum\API;
use SmartpingApi\Enum\TypeEquipe;
use SmartpingApi\Model\Club\Club;
use SmartpingApi\Model\Club\DetailClub;
use SmartpingApi\Model\Club\Equipe;

final readonly class ClubService implements ClubContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function clubsParDepartement(string $departement): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_DEP_2, ['dep' => $departement]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function clubsParCodePostal(string $codePostal): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_B, ['code' => $codePostal]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function clubsParVille(string $ville): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_B, ['ville' => $ville]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function clubsParNom(string $nom): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_B, ['ville' => $nom]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function detailClub(string $code, ?string $idEquipe = null): \SmartpingApi\Model\Club\DetailClub
    {
        $params = ['club' => $code];

        if ($idEquipe !== null) {
            $params['idequipe'] = $idEquipe;
        }

        $response = $this->httpClient->fetch(API::XML_CLUB_DETAIL, $params);

        return DetailClub::fromArray($response['club']);
    }

    /** @inheritdoc */
    public function equipesClub(string $code, TypeEquipe $typeEquipe): array
    {
        $response = $this->httpClient->fetch(API::XML_EQUIPE, [
            'numclu' => $code,
            'type' => $typeEquipe->value,
        ]);

        return array_map(
            Equipe::fromArray(...),
            $response['equipe'] ?? []
        );
    }
}
