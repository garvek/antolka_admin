<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZoneRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(name="name_idx", columns={"name"}),
 *     @ORM\Index(name="crime_allowed_idx", columns={"crime_allowed"}),
 *     @ORM\Index(name="combat_allowed_idx", columns={"combat_allowed"}),
 *     @ORM\Index(name="search_allowed_idx", columns={"search_allowed"}),
 *     @ORM\Index(name="crop_allowed_idx", columns={"crop_allowed"}),
 *     @ORM\Index(name="shout_allowed_idx", columns={"shout_allowed"}),
 *     @ORM\Index(name="radio_allowed_idx", columns={"radio_allowed"})
 * })
 */
class Zone
{
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
     * @ORM\Column(type="string", length=200)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="zones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\Column(type="boolean")
     */
    private $crimeAllowed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $combatAllowed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $searchAllowed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cropAllowed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $shoutAllowed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $radioAllowed;

    /**
     * @ORM\OneToMany(targetEntity=Tile::class, mappedBy="zone")
     */
    private $tiles;

    public function __construct()
    {
        $this->tiles = new ArrayCollection();
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
        return $this->name ?? 'Zone #' . (string)$this->getId();
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }
    
    public function getCrimeAllowed(): ?bool
    {
        return $this->crimeAllowed;
    }

    public function setCrimeAllowed(bool $crimeAllowed): self
    {
        $this->crimeAllowed = $crimeAllowed;

        return $this;
    }

    public function getCombatAllowed(): ?bool
    {
        return $this->combatAllowed;
    }

    public function setCombatAllowed(bool $combatAllowed): self
    {
        $this->combatAllowed = $combatAllowed;

        return $this;
    }

    public function getSearchAllowed(): ?bool
    {
        return $this->searchAllowed;
    }

    public function setSearchAllowed(bool $searchAllowed): self
    {
        $this->searchAllowed = $searchAllowed;

        return $this;
    }

    public function getCropAllowed(): ?bool
    {
        return $this->cropAllowed;
    }

    public function setCropAllowed(bool $cropAllowed): self
    {
        $this->cropAllowed = $cropAllowed;

        return $this;
    }

    public function getShoutAllowed(): ?bool
    {
        return $this->shoutAllowed;
    }

    public function setShoutAllowed(bool $shoutAllowed): self
    {
        $this->shoutAllowed = $shoutAllowed;

        return $this;
    }

    public function getRadioAllowed(): ?bool
    {
        return $this->radioAllowed;
    }

    public function setRadioAllowed(bool $radioAllowed): self
    {
        $this->radioAllowed = $radioAllowed;

        return $this;
    }

    /**
     * @return Collection|Tile[]
     */
    public function getTiles(): Collection
    {
        return $this->tiles;
    }

    public function addTile(Tile $tile): self
    {
        if (!$this->tiles->contains($tile)) {
            $this->tiles[] = $tile;
            $tile->setZone($this);
        }

        return $this;
    }

    public function removeTile(Tile $tile): self
    {
        if ($this->tiles->removeElement($tile)) {
            // set the owning side to null (unless already changed)
            if ($tile->getZone() === $this) {
                $tile->setZone(null);
            }
        }

        return $this;
    }
}
