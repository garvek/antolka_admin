<?php

namespace App\Entity;

use App\Repository\GameLogReaderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameLogReaderRepository::class)
 */
class GameLogReader
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
     * @ORM\ManyToOne(targetEntity=GameLog::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $gameLog;

    /**
     * @ORM\ManyToOne(targetEntity=Adventurer::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $reader;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getGameLog(): ?GameLog
    {
        return $this->gameLog;
    }

    public function setGameLog(?GameLog $gameLog): self
    {
        $this->gameLog = $gameLog;

        return $this;
    }

    public function getReader(): ?Adventurer
    {
        return $this->reader;
    }

    public function setReader(?Adventurer $reader): self
    {
        $this->reader = $reader;

        return $this;
    }
}
