<?php

declare(strict_types=1);

namespace SmartpingApi\Exception;

class AuthentificationException extends \RuntimeException
{
    public static function make(string $error): self
    {
        return new self("Erreur d'authentification : $error");
    }
}
