<?php

namespace App\Form\Editor;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Form\Type\AttributeAndValueData;

class AdventurerCreationData
{
    private $name = '';
    private $x = 0;
    private $y = 0;
    private $z = 0;
    private $attributes;
    
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function getZ(): ?int
    {
        return $this->z;
    }

    /**
     * @return Collection|AttributeAndValueData[]
     */
    public function getAttributes(): Collection {
        return $this->attributes;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setX(?int $x): self
    {
        $this->x = $x;
        return $this;
    }

    public function setY(?int $y): self
    {
        $this->y = $y;
        return $this;
    }

    public function setZ(?int $z): self
    {
        $this->z = $z;
        return $this;
    }

    public function addAttribute(AttributeAndValueData $attribute): self
    {
        foreach ($this->attributes as $attributeI) {
            if ($attributeI->getAttribute() == $attribute->getAttribute()) {
                $attributeI->setValue($attribute->getValue());
                return $this;
            }
        }
        $this->attributes[] = $attribute;
        return $this;
    }

    public function removeAttribute(AttributeAndValueData $attribute): self
    {
        foreach ($this->attributes as $attributeI) {
            if ($attributeI->getAttribute() == $attribute->getAttribute()) {
                $this->attributes->removeElement($attributeI);
                break;
            }
        }
        return $this;
    }
}
