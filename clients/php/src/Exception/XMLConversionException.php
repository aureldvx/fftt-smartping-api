<?php

declare(strict_types=1);

namespace SmartpingApi\Exception;

class XMLConversionException extends \RuntimeException
{
    public static function make(): self
    {
        return new self('Erreur lors de la conversion XML.');
    }
}
