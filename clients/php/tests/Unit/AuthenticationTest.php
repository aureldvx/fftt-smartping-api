<?php

declare(strict_types=1);

use SmartpingApi\Core\HttpClientMock;
use SmartpingApi\Smartping;

beforeEach(function (): void {
    $this->api = Smartping::create('', '', '', new HttpClientMock);
});

it("devrait s'authentifier", function (): void {
    $result = $this->api->authentification->authentifier();

    expect($result)->toBeTrue();
});
