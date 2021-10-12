<?php

namespace App\Entity;

use App\Repository\TileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TileRepository::class)
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="coord_idx", columns={"x","y","z"})
 * })
 */
class Tile
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
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @ORM\Column(type="integer")
     */
    private $z;

    /**
     * @ORM\Column(type="smallint")
     */
    private $viewbox;

    /**
     * @ORM\Column(type="smallint")
     */
    private $collidebox;

    /**
     * @ORM\ManyToOne(targetEntity=TileImage::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $allowedVehicles;

    /**
     * @ORM\ManyToOne(targetEntity=Zone::class, inversedBy="tiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getZ(): ?int
    {
        return $this->z;
    }

    public function setZ(int $z): self
    {
        $this->z = $z;

        return $this;
    }
    
    public function __toString(): string
    {
        return (string)$this->getX() . '/' . (string)$this->getY() . '/' . (string)$this->getZ();
    }

    public function getViewbox(): ?int
    {
        return $this->viewbox;
    }

    public function setViewbox(int $viewbox): self
    {
        $this->viewbox = $viewbox;

        return $this;
    }

    public function getCollidebox(): ?int
    {
        return $this->collidebox;
    }

    public function setCollidebox(int $collidebox): self
    {
        $this->collidebox = $collidebox;

        return $this;
    }

    public function getImage(): ?TileImage
    {
        return $this->image;
    }

    public function setImage(?TileImage $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAllowedVehicles(): ?int
    {
        return $this->allowedVehicles;
    }

    public function setAllowedVehicles(int $allowedVehicles): self
    {
        $this->allowedVehicles = $allowedVehicles;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
