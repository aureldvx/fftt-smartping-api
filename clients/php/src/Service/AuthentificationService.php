<?php

declare(strict_types=1);

namespace SmartpingApi\Service;

use SmartpingApi\Contract\AuthentificationContract;
use SmartpingApi\Core\HttpClientContract;
use SmartpingApi\Enum\API;
use SmartpingApi\Exception\AuthentificationException;
use SmartpingApi\Model\Divers\Initialisation;

final readonly class AuthentificationService implements AuthentificationContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function authentifier(): bool
    {
        $response = $this->httpClient->fetch(API::XML_INITIALISATION, []);

        if (array_key_exists('appli', $response)) {
            return Initialisation::fromArray($response)->appli();
        }

        throw AuthentificationException::make($response['user']['erreur']);
    }
}
