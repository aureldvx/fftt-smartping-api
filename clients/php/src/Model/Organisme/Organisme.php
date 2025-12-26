<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Organisme;

use SmartpingApi\Enum\TypeOrganisme;
use SmartpingApi\Model\CanDeserialize;
use SmartpingApi\Model\CanSerialize;
use SmartpingApi\Util\ValueTransformer;

final readonly class Organisme implements CanSerialize, CanDeserialize
{
    private int $id;

    private string $libelle;

    private string $code;

    private ?int $idOrganismeParent;

    private TypeOrganisme $type;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->id = (int) $data['id'];
        $model->libelle = $data['libelle'];
        $model->code = $data['code'];
        $model->idOrganismeParent = ValueTransformer::nullOrInt($data['idPere']);
        $model->type = TypeOrganisme::from(substr($data['code'], 0, 1));

        return $model;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function libelle(): string
    {
        return $this->libelle;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function idOrganismeParent(): ?int
    {
        return $this->idOrganismeParent;
    }

    public function type(): TypeOrganisme
    {
        return $this->type;
    }

    /**
     * @return array{id: int, libelle: string, code: string, id_organisme_parent: string, type: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'code' => $this->code,
            'id_organisme_parent' => $this->idOrganismeParent,
            'type' => $this->type->value,
        ];
    }
}
