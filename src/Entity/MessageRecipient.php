<?php

namespace App\Entity;

use App\Repository\MessageRecipientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRecipientRepository::class)
 */
class MessageRecipient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Version
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @ORM\ManyToOne(targetEntity=Adventurer::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="recipients")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $opened;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getRecipient(): ?Adventurer
    {
        return $this->recipient;
    }

    public function setRecipient(?Adventurer $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getOpened(): ?bool
    {
        return $this->opened;
    }

    public function setOpened(bool $opened): self
    {
        $this->opened = $opened;

        return $this;
    }
}
