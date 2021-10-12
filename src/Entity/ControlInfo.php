<?php

namespace App\Entity;

use App\Repository\ControlInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ControlInfoRepository::class)
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="control_unique", columns={"user_id", "adventurer_id"})
 * })
 */
class ControlInfo
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="controlInfos")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Adventurer::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $adventurer;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastIp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getLastIp(): ?string
    {
        return $this->lastIp;
    }

    public function setLastIp(?string $lastIp): self
    {
        $this->lastIp = $lastIp;

        return $this;
    }
    
    public function getLastDate(): ?\DateTimeInterface
    {
        return $this->lastDate;
    }

    public function setLastDate(?\DateTimeInterface $lastDate): self
    {
        $this->lastDate = $lastDate;

        return $this;
    }
}
