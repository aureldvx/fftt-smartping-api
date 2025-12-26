<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Epreuve\ParEquipes\Rencontre;

use SmartpingApi\Model\CanSerialize;
use SmartpingApi\Util\ScoreUtils;
use SmartpingApi\Util\ValueTransformer;

final readonly class PartieRencontre implements CanSerialize
{
    private ?string $joueurA;

    private ?string $joueurB;

    private ?int $scoreA;

    private ?int $scoreB;

    /** @var array<int> */
    private array $detailManches;

    /** @var array<array-key, array<int>> */
    private array $detailManchesComplet;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->joueurA = ValueTransformer::nullOrString($data['ja']);
        $model->joueurB = ValueTransformer::nullOrString($data['jb']);
        $model->scoreA = $data['scorea'] === '-' ? 0 : (int) $data['scorea'];
        $model->scoreB = $data['scoreb'] === '-' ? 0 : (int) $data['scoreb'];
        $model->detailManches = array_map(
            static fn (string $score): int => (int) $score,
            explode(' ', $data['detail'])
        );
        $model->detailManchesComplet = ScoreUtils::detaillerScores($model->detailManches);

        return $model;
    }
}
