<?php

declare(strict_types=1);

use SmartpingApi\Core\HttpClientMock;
use SmartpingApi\Enum\TypeEpreuve;
use SmartpingApi\Model\Epreuve\Division;
use SmartpingApi\Model\Epreuve\Epreuve;
use SmartpingApi\Smartping;

beforeEach(function (): void {
    $this->api = Smartping::create('', '', '', new HttpClientMock);
});

it("devrait récupérer la liste des épreuves", function (): void {
    $result = $this->api->epreuve->rechercherEpreuves(123, TypeEpreuve::AUTRE_EPREUVE_INDIVIDUELLE);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Epreuve::class)
        ->and($result[0]->idEpreuve())->toBe(256);
});

it("devrait récupérer les divisions d'une épreuve", function (): void {
    $result = $this->api->epreuve->rechercherDivisionsPourEpreuve(123, 456, TypeEpreuve::AUTRE_EPREUVE_INDIVIDUELLE);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Division::class)
        ->and($result[0]->id())->toBe(196680);
});
