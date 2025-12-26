<?php

declare(strict_types=1);

namespace SmartpingApi\Contract;

use SmartpingApi\Enum\TypeEpreuve;
use SmartpingApi\Model\Epreuve\Division;
use SmartpingApi\Model\Epreuve\Epreuve;

interface EpreuveContract
{
    /**
     * Endpoint : xml_epreuve.php
     * ---------------------------------------------------------
     * Renvoie une liste des épreuves pour un organisme.
     *
     * @return array<array-key, Epreuve> Ensemble des épreuves trouvées
     */
    public function rechercherEpreuves(int $organizationId, TypeEpreuve $contestType): array;

    /**
     * Endpoint : xml_division.php
     * ---------------------------------------------------------
     * Renvoie une liste des divisions pour une épreuve donnée.
     *
     * @return array<array-key, Division> Ensemble des divisions trouvées
     */
    public function rechercherDivisionsPourEpreuve(
        int $organizationId,
        int $contestId,
        TypeEpreuve $contestType
    ): array;
}
