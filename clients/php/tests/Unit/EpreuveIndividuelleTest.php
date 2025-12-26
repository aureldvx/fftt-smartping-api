<?php

declare(strict_types=1);

use SmartpingApi\Core\HttpClientMock;
use SmartpingApi\Model\Epreuve\Individuelle\Classement;
use SmartpingApi\Model\Epreuve\Individuelle\Groupe;
use SmartpingApi\Model\Epreuve\Individuelle\Partie;
use SmartpingApi\Smartping;

beforeEach(function () {
    $this->api = Smartping::create('', '', '', new HttpClientMock);
});

it("devrait récupérer les groupes d'une division", function () {
    $result = $this->api->epreuveIndividuelle->rechercherGroupes(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Groupe::class)
        ->and($result[0]->libelle())->toBe('T4 Gr1');
});

it("devrait récupérer les parties d'une division", function () {
    $result = $this->api->epreuveIndividuelle->recupererParties(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Partie::class)
        ->and($result[0]->libelle())->toBe('Finale');
});

it("devrait récupérer le classement d'une division", function () {
    $result = $this->api->epreuveIndividuelle->recupererClassement(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Classement::class)
        ->and($result[0]->pointsCriterium())->toBe('150A');
});

it("devrait récupérer le classement d'une division de CF nouvelle formule", function () {
    $result = $this->api->epreuveIndividuelle->recupererClassementCriterium(123);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Classement::class)
        ->and($result[0]->pointsCriterium())->toBe('150A');
});
