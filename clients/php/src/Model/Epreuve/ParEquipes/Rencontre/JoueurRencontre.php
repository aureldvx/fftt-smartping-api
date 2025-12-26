<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Epreuve\ParEquipes\Rencontre;

use SmartpingApi\Enum\Sexe;
use SmartpingApi\Model\CanSerialize;
use SmartpingApi\Util\JoueurUtils;

final readonly class JoueurRencontre implements CanSerialize
{
    private ?string $joueurA;

    private ?string $joueurB;

    private ?float $pointsOfficielsA;

    private ?float $pointsOfficielsB;

    private ?int $rangNationalA;

    private ?int $rangNationalB;

    private ?Sexe $sexeA;

    private ?Sexe $sexeB;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->joueurA = $data['xja'];
        $model->joueurB = $data['xjb'];

        $classementA = JoueurUtils::parseClassementJoueur($data['xca']);
        $model->rangNationalA = $classementA['numero'];
        $model->sexeA = $classementA['sexe'];
        $model->pointsOfficielsA = $classementA['points'];

        $classementB = JoueurUtils::parseClassementJoueur($data['xcb']);
        $model->rangNationalB = $classementB['numero'];
        $model->sexeB = $classementB['sexe'];
        $model->pointsOfficielsB = $classementB['points'];

        return $model;
    }
}
