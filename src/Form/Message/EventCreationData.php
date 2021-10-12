<?php

namespace App\Form\Message;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Adventurer;

class EventCreationData
{
    private $publisher;
    private $recipients;
    private $title;
    private $content;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * @return Collection|Adventurer[]
     */
    public function getRecipients(): Collection {
        return $this->recipients;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function addRecipient(Adventurer $recipient): self
    {
        foreach ($this->recipients as $recipientsI) {
            if ($recipientsI->getId() == $recipient->getId()) {
                return $this;
            }
        }
        $this->recipients[] = $recipient;
        return $this;
    }

    public function removeRecipient(Adventurer $recipient): self
    {
        foreach ($this->recipients as $recipientsI) {
            if ($recipientsI->getId() == $recipient->getId()) {
                $this->recipients->removeElement($recipientsI);
                break;
            }
        }
        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
