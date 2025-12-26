<?php

declare(strict_types=1);

namespace SmartpingApi\Model;

interface CanSerialize
{
    public static function fromArray(array $data): self;
}
