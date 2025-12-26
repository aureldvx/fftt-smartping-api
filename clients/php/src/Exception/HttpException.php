<?php

declare(strict_types=1);

namespace SmartpingApi\Exception;

class HttpException extends \RuntimeException
{
    public static function make(string $error): self
    {
        return new self(
            message: "Unexpected error happened while fetching FFTT servers.",
            previous: new \Exception($error),
        );
    }
}
