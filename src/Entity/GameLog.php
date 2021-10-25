<?php

namespace App\Entity;

use App\Repository\GameLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameLogRepository::class)
 * @ORM\Table(
 *   indexes={
 *     @ORM\Index(name="type_idx", columns={"type"}),
 *     @ORM\Index(name="date_idx", columns={"date"})
 *   }
 * )
 */
class GameLog
{
    /* moves */
    public const TYPE_WALK = 1;
    public const TYPE_RUN = 2;
    public const TYPE_JUMP = 3;
    public const TYPE_CLIMB = 4;
    public const TYPE_FALL = 5;
    public const TYPE_CRAWL = 6;
    /* special moves */
    public const TYPE_DOOR_USE = 51;
    public const TYPE_LADDER_USE = 52;
    public const TYPE_STAIRS_USE = 53;
    public const TYPE_ELEVATOR_USE = 54;
    public const TYPE_ROPE_USE = 55;
    public const TYPE_ZIPLINE_USE = 56;
    /* social interactions */
    public const TYPE_TALK = 101;
    public const TYPE_YELL = 102;
    public const TYPE_DISCUSS = 103;
    public const TYPE_BARGAIN = 104;
    public const TYPE_INTIMIDATE = 105;
    public const TYPE_SEDUCE = 106;
    /* combat interactions */
    public const TYPE_PUNCH = 201;
    public const TYPE_SLASH = 202;
    public const TYPE_SHOOT = 203;
    public const TYPE_CAST = 204;
    public const TYPE_CRIPPLE = 205;
    public const TYPE_KNOCK = 206;
    /* object interactions */
    public const TYPE_FOOD_USE = 301;
    public const TYPE_POTION_USE = 302;
    public const TYPE_OINTMENT_USE = 303;
    public const TYPE_BANDAGE_USE = 304;
    public const TYPE_LIGHTER_USE = 305;
    public const TYPE_BED_USE = 306;
    /* special object interactions */
    public const TYPE_DOOR_LOCK = 351;
    public const TYPE_DOOR_UNLOCK = 352;
    public const TYPE_CHEST_LOCK = 353;
    public const TYPE_CHEST_UNLOCK = 354;
    public const TYPE_VEHICLE_LOCK = 355;
    public const TYPE_VEHICLE_UNLOCK = 356;
    /* equipment */
    public const TYPE_OBJECT_PICK = 401;
    public const TYPE_OBJECT_DROP = 402;
    public const TYPE_CLOTHES_DRESS = 403;
    public const TYPE_CLOTHES_UNDRESS = 404;
    public const TYPE_WEAPON_UNSHEATH = 405;
    public const TYPE_WEAPON_SHEATH = 406;
    
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
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Adventurer::class)
     */
    private $source;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Adventurer::class)
     */
    private $target;

    /**
     * @ORM\Column(type="json")
     */
    private $params = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSource(): ?Adventurer
    {
        return $this->source;
    }

    public function setSource(?Adventurer $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function __toString(): string
    {
        return 'GameLog #' . $this->getId() . ' (' . $this->getDate()->format(\DateTimeInterface::RFC822) . ') [' . $this->getType() . ']';
    }

    public function getTarget(): ?Adventurer
    {
        return $this->target;
    }

    public function setTarget(?Adventurer $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getParams(): ?array
    {
        return $this->params;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }
}
