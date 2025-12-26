<?php

declare(strict_types=1);

namespace SmartpingApi\Service;

use SmartpingApi\Contract\EpreuveParEquipeContract;
use SmartpingApi\Core\HttpClientContract;
use SmartpingApi\Enum\API;
use SmartpingApi\Model\Epreuve\ParEquipes\Poule\EquipePoule;
use SmartpingApi\Model\Epreuve\ParEquipes\Poule\Poule;
use SmartpingApi\Model\Epreuve\ParEquipes\Rencontre\DetailRencontre;
use SmartpingApi\Model\Epreuve\ParEquipes\Rencontre\Rencontre;

final readonly class EpreuveParEquipeService implements EpreuveParEquipeContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function poulesPourDivision(int $divisionId): array
    {
        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, [
            'action' => 'poule',
            'auto' => 1,
            'D1' => $divisionId,
        ]);

        return array_map(fn ($item) => Poule::fromArray($item), $response['poule'] ?? []);
    }

    /** @inheritdoc */
    public function rencontresPourPoule(int $divisionId, ?int $pouleId = null): array
    {
        $params = [
            'action' => '',
            'auto' => 1,
            'D1' => $divisionId,
        ];

        if ($pouleId !== null) {
            $params['cx_poule'] = $pouleId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, $params);

        return array_map(fn ($item) => Rencontre::fromArray($item), $response['tour'] ?? []);
    }

    /** @inheritdoc */
    public function ordrePoule(int $divisionId, ?int $pouleId = null): array
    {
        $params = [
            'action' => 'initial',
            'auto' => 1,
            'D1' => $divisionId,
        ];

        if ($pouleId !== null) {
            $params['cx_poule'] = $pouleId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, $params);

        $results = [];

        foreach ($response['classement'] ?? [] as $index => $item) {
            $item['pos'] = $index + 1;
            $results[] = EquipePoule::fromArray($item);
        }

        return $results;
    }

    /** @inheritdoc */
    public function classementPoule(int $divisionId, ?int $pouleId = null): array
    {
        $params = [
            'action' => 'classement',
            'auto' => 1,
            'D1' => $divisionId,
        ];

        if ($pouleId !== null) {
            $params['cx_poule'] = $pouleId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, $params);

        return array_map(fn ($item) => EquipePoule::fromArray($item), $response['classement'] ?? []);
    }

    /** @inheritdoc */
    public function detailRencontre(int $rencontreId, array $extraParams): ?DetailRencontre
    {
        $response = $this->httpClient->fetch(API::XML_CHP_RENC, [
            'is_retour' => $extraParams['is_retour'],
            'phase' => $extraParams['phase'],
            'res_1' => $extraParams['res_1'],
            'res_2' => $extraParams['res_2'],
            'renc_id' => $rencontreId,
            'equip_1' => $extraParams['equip_1'],
            'equip_2' => $extraParams['equip_2'],
            'equip_id1' => $extraParams['equip_id1'],
            'equip_id2' => $extraParams['equip_id2'],
        ]);

        return DetailRencontre::fromArray($response);
    }
}
