<?php

namespace App\Form\Editor;

use App\Entity\Adventurer;
use App\Entity\User;

class AdventurerControlData
{
    private $user = null;
    private $adventurer = null;
    
    public function getUser(): ?User {
        return $this->user;
    }

    public function getAdventurer(): ?Adventurer {
        return $this->adventurer;
    }

    public function setUser(?User $user): self {
        $this->user = $user;
        return $this;
    }

    public function setAdventurer(?Adventurer $adventurer): self {
        $this->adventurer = $adventurer;
        return $this;
    }
}
