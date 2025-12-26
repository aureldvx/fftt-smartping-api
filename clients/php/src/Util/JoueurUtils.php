<?php

declare(strict_types=1);

namespace SmartpingApi\Util;

use SmartpingApi\Enum\Sexe;
use SmartpingApi\Model\Joueur\Joueur;
use SmartpingApi\Model\Joueur\JoueurBaseClassement;
use SmartpingApi\Model\Joueur\JoueurBaseSPID;

final class JoueurUtils
{
    /**
     * @param string $classement
     *
     * @return array{numero?: int, sexe?: Sexe, points?: float}
     */
    public static function parseClassementJoueur(string $classement): array
    {
        if (preg_match('/^\d+$/', $classement)) {
            return [
                'numero' => null,
                'points' => (int) $classement,
                'sexe' => null
            ];
        }

        $regex = '/^N(?:°)?\s*(?<numero>\d+)\D+(?<sexe>[MF])?\s*(?<points>\d+)/u';

        preg_match($regex, $classement, $matches);

        return [
            'numero' => (int) $matches['numero'],
            'sexe' => ValueTransformer::nullOrEnum($matches['sexe'], Sexe::class),
            'points' => (float) $matches['points'],
        ];
    }

    /**
     * Séparer le nom et prénom d'un joueur lorsque l'API les retourne dans
     * une seule et même chaîne de caractères.
     *
     * @return array{0: string, 1: string} Tableau contenant le nom (index 0) et le prénom (index 1)
     */
    public static function separerNomPrenom(string $nomPrenom): array
    {
        /**
         * Les expressions régulières sont récupérées depuis un repository tiers.
         * @see https://github.com/alamirault/fftt-api-src/blob/main/src/Service/NomPrenomExtractor.php
         */
        $result = preg_match(
            pattern: "/^(?<nom>[A-ZÀ-Ý]+(?:[\s'\-]*[A-ZÀ-Ý]+)*)\s(?<prenom>[A-ZÀ-Ý][a-zà-ÿ]*(?:[\s'\-]*[A-ZÀ-Ý][a-zà-ÿ]*)*)$/",
            subject: preg_replace(['/\s+/', '/-+/'], [' ', '-'], $nomPrenom) ?? '',
            matches: $matches,
        );

        if ($result !== 1) {
            return ['', ''];
        }

        return [$matches['nom'], $matches['prenom']];
    }

    public static function fusionnerJoueurs(array $baseClassement, array $baseSPID): array
    {
        return [];
    }

    public static function fusionnerJoueur(JoueurBaseClassement $baseClassement, JoueurBaseSPID $baseSPID): Joueur
    {
        /**
         * @param array $list
         * @param RankedPlayer|SPIDPlayer $player
         *
         * @return array
         */
        $indexByLicence = /**
         * @return (\SmartpingApi\Model\Player\RankedPlayer|\SmartpingApi\Model\Player\SPIDPlayer|mixed)[]
         *
         * @psalm-return array<\SmartpingApi\Model\Player\RankedPlayer|\SmartpingApi\Model\Player\SPIDPlayer|mixed>
         */
            function (array $list, RankedPlayer|SPIDPlayer $player): array {
                $list[$player->licence()] = $player;

                return $list;
            };

        /** @var RankedPlayer[] $rankedIndexed */
        $rankedIndexed = empty($rankedCollection) ? [] : array_reduce($rankedCollection, $indexByLicence, []);

        /** @var SPIDPlayer[] $spidIndexed */
        $spidIndexed = empty($spidCollection) ? [] : array_reduce($spidCollection, $indexByLicence, []);

        $rankedKeys = array_keys($rankedIndexed);
        $spidKeys = array_keys($spidIndexed);

        /** @var array<Player> $results */
        $results = [];

        foreach ($rankedKeys as $licence) {
            if (in_array($licence, $spidKeys)) {
                $results[] = new Player(
                    spidPlayer: $spidIndexed[$licence],
                    rankedPlayer: $rankedIndexed[$licence]
                );

                unset($spidIndexed[$licence]);
            } else {
                $results[] = new Player(
                    spidPlayer: null,
                    rankedPlayer: $rankedIndexed[$licence]
                );
            }

            unset($rankedIndexed[$licence]);
        }

        if (count($spidIndexed) > 0) {
            foreach ($spidIndexed as $player) {
                $results[] = new Player(
                    spidPlayer: $player,
                    rankedPlayer: null
                );
            }
        }

        return $results;
    }
}
