<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(name="name_idx", columns={"name"}),
 *     @ORM\Index(name="category_idx", columns={"category"})
 * })
 */
class Vehicle
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
     * @ORM\Column(type="smallint")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Tile::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $tile;

    /**
     * @ORM\OneToMany(targetEntity=VehiclePassenger::class, mappedBy="vehicle")
     */
    private $passengers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDriving;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
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
        return $this->name ?? 'Vehicle #' . (string)$this->getId();
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

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
     * @return Collection|VehiclePassenger[]
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(VehiclePassenger $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
            $passenger->setVehicle($this);
        }

        return $this;
    }

    public function removePassenger(VehiclePassenger $passenger): self
    {
        if ($this->passengers->removeElement($passenger)) {
            // set the owning side to null (unless already changed)
            if ($passenger->getVehicle() === $this) {
                $passenger->setVehicle(null);
            }
        }

        return $this;
    }

    public function getIsDriving(): ?bool
    {
        return $this->isDriving;
    }

    public function setIsDriving(bool $isDriving): self
    {
        $this->isDriving = $isDriving;

        return $this;
    }
}
