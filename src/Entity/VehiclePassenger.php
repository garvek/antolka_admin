<?php

namespace App\Entity;

use App\Repository\VehiclePassengerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehiclePassengerRepository::class)
 * @ORM\Table(
 *   indexes={
 *     @ORM\Index(name="seat_idx", columns={"seat"})
 *   },
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="vehicle_seat_idx", columns={"vehicle_id","seat"})
 *   }
 * )
 */
class VehiclePassenger
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
     * @ORM\ManyToOne(targetEntity=Vehicle::class, inversedBy="passengers")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $vehicle;

    /**
     * @ORM\OneToOne(targetEntity=Adventurer::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $adventurer;

    /**
     * @ORM\Column(type="smallint")
     */
    private $seat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getAdventurer(): ?Adventurer
    {
        return $this->adventurer;
    }

    public function setAdventurer(?Adventurer $adventurer): self
    {
        $this->adventurer = $adventurer;

        return $this;
    }

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): self
    {
        $this->seat = $seat;

        return $this;
    }
}
