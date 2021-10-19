<?php

namespace App\Form\Cartographer;

use App\Entity\Region;

class ZoneCreationData
{
    private $name;
    private $region;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;
        return $this;
    }
}
