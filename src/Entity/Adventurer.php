<?php

namespace App\Entity;

use App\Repository\AdventurerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdventurerRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(name="name_idx", columns={"name"}),
 *     @ORM\Index(name="ctl_type_idx", columns={"control_type"})
 * })
 */
class Adventurer
{
    public const TYPE_PLAYER_MAIN = 0;
    public const TYPE_PLAYER_MINION = 1;
    public const TYPE_GAMEMASTER = 10;
    public const TYPE_AUTOMATED = 20;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Version()
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $controlType;

    /**
     * @ORM\ManyToOne(targetEntity=Tile::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $tile;

    /**
     * @ORM\OneToMany(targetEntity=AdventurerAttribute::class, mappedBy="adventurer")
     */
    private $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function __toString(): string
    {
            return $this->name ?? 'Adventurer #' . (string)$this->getId();
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getControlType(): ?int
    {
        return $this->controlType;
    }

    public function setControlType(int $controlType): self
    {
        $this->controlType = $controlType;

        return $this;
    }

    public function getTile(): ?Tile
    {
        return $this->tile;
    }

    public function setTile(?Tile $tile): self
    {
        $this->tile = $tile;

        return $this;
    }

    /**
     * @return Collection|AdventurerAttribute[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(AdventurerAttribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setAdventurer($this);
        }

        return $this;
    }

    public function removeAttribute(AdventurerAttribute $attribute): self
    {
        if ($this->attributes->removeElement($attribute)) {
            // set the owning side to null (unless already changed)
            if ($attribute->getAdventurer() === $this) {
                $attribute->setAdventurer(null);
            }
        }

        return $this;
    }
}
