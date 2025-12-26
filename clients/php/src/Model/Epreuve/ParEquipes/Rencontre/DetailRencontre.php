<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Epreuve\ParEquipes\Rencontre;

use SmartpingApi\Model\CanSerialize;

/**
 * Modélise le retour du call `xml_chp_renc`.
 *
 * @see /docs/snapshots/xml_chp_renc/default.xml
 * @see /docs/snapshots/xml_chp_renc/numerotes.xml
 */
final readonly class DetailRencontre implements CanSerialize
{
    private ResultatRencontre $resultat;

    /** @var array<JoueurRencontre> */
    private array $joueurs;

    /** @var array<PartieRencontre> */
    private array $parties;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->resultat = ResultatRencontre::fromArray($data['resultat']);
        $model->joueurs = array_map(
            fn (array $joueur): JoueurRencontre => JoueurRencontre::fromArray($joueur),
            $data['joueur']
        );
        $model->parties = array_map(
            fn (array $partie): PartieRencontre => PartieRencontre::fromArray($partie),
            $data['partie']
        );

        return $model;
    }

    public function resultat(): ResultatRencontre
    {
        return $this->resultat;
    }

    /** @return array<JoueurRencontre> */
    public function joueurs(): array
    {
        return $this->joueurs;
    }

    /** @return array<PartieRencontre> */
    public function parties(): array
    {
        return $this->parties;
    }
}

