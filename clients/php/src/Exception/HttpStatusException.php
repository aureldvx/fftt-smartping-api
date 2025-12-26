<?php

declare(strict_types=1);

namespace SmartpingApi\Exception;

class HttpStatusException extends \RuntimeException
{
    public static function make(int $code): self
    {
        return new self(sprintf('Received HTTP code %d, expected 200', $code));
    }
}
