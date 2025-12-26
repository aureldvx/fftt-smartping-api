<?php

declare(strict_types=1);

use SmartpingApi\Core\HttpClientMock;
use SmartpingApi\Model\Epreuve\ParEquipes\Poule\EquipePoule;
use SmartpingApi\Model\Epreuve\ParEquipes\Poule\Poule;
use SmartpingApi\Model\Epreuve\ParEquipes\Rencontre\DetailRencontre;
use SmartpingApi\Model\Epreuve\ParEquipes\Rencontre\Rencontre;
use SmartpingApi\Smartping;

beforeEach(function () {
    $this->api = Smartping::create('', '', '', new HttpClientMock);
});

it("devrait récupérer les poules d'une division", function () {
    $result = $this->api->epreuveParEquipe->poulesPourDivision(123);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Poule::class)
        ->and($result[0]->libelle())->toBe('Poule 1');
});

it("devrait récupérer les rencontres d'une poule", function () {
    $result = $this->api->epreuveParEquipe->rencontresPourPoule(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Rencontre::class)
        ->and($result[0]->libelle())->toBe('Poule 2 - tour n°1 du 13/09/2025');
});

it("devrait récupérer les équipes d'une poule dans l'ordre de départ", function () {
    $result = $this->api->epreuveParEquipe->ordrePoule(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(EquipePoule::class)
        ->and($result[0]->idEquipe())->toBe(1590);
});

it("devrait récupérer le classement d'une poule", function () {
    $result = $this->api->epreuveParEquipe->classementPoule(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(EquipePoule::class)
        ->and($result[0]->idEquipe())->toBe(1870);
});

it("devrait récupérer le détail d'une rencontre", function () {
    $result = $this->api->epreuveParEquipe->detailRencontre(123, []);

    expect($result)
        ->toBeInstanceOf(DetailRencontre::class)
        ->and($result->resultat()->equipeA())->toBe('Chateaubernard 3')
        ->and($result->resultat()->equipeB())->toBe('Vars EP 1');
});
