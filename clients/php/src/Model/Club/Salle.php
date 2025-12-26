<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Club;

final readonly class Salle
{
    public function __construct(
        public string $nom,
        public string $ligneAdresse1,
        public string $codePostal,
        public string $ville,
        public ? string $ligneAdresse2 = null,
        public ? string $ligneAdresse3 = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
    ) {}

    public function adresseComplete(): string
    {
        $address = "$this->nom - $this->ligneAdresse1";

        if ($this->ligneAdresse2) {
            $address .= " - $this->ligneAdresse2";
        }

        if ($this->ligneAdresse3) {
            $address .= " - $this->ligneAdresse3";
        }

        $address .= " - $this->codePostal $this->ville";

        return $address;
    }

    public function __toString(): string
    {
        return $this->adresseComplete();
    }
}
