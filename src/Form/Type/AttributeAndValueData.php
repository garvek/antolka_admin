<?php

namespace App\Form\Type;

class AttributeAndValueData
{
    private $attribute = 0;
    private $value = 0;

    public function getAttribute(): ?int
    {
        return $this->attribute;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setAttribute(?int $attribute): self
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function setValue(?int $value): self
    {
        $this->value = $value;
        return $this;
    }
}
