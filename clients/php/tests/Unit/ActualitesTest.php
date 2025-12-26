<?php

declare(strict_types=1);

use SmartpingApi\Core\HttpClientMock;
use SmartpingApi\Model\Divers\Actualite;
use SmartpingApi\Smartping;

beforeEach(function () {
    $this->api = Smartping::create('', '', '', new HttpClientMock);
});

it('devrait récupérer les dernières actualités de la fédération', function () {
    $actualites = $this->api->actualites->fluxActualitesFederation();

    expect($actualites)->toBeArray()
        ->and($actualites)->not->toBeEmpty()
        ->and($actualites[0])->toBeInstanceOf(Actualite::class)
        ->and($actualites[0]->titre())->toBe('Disparition de Christian Gendraud');
});
