<?php

namespace App\Entity;

use App\Repository\TileImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TileImageRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(name="category_idx", columns={"category"})
 * })
 */
class TileImage
{
    public const CAT_DEFAULT = 0;
    public const CAT_SURFACE = 1;
    public const CAT_OBSTACLE = 2;
    public const CAT_INTERIOR = 10;
    public const CAT_EXTERIOR = 20;
    
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
     * @ORM\Column(type="smallint")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $filename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }
    
    public function __toString(): string
    {
        return $this->filename ?? 'TileImage #' . (string)$this->getId();
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }
}
