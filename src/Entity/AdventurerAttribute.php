<?php

namespace App\Entity;

use App\Repository\AdventurerAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdventurerAttributeRepository::class)
 */
class AdventurerAttribute
{
    // base
    public const _ATTRIBUTE_NONE = 0;
    public const ATTRIBUTE_HEALTH = 1;
    public const ATTRIBUTE_FATIGUE = 2;
    public const ATTRIBUTE_MOVES = 3;
    public const ATTRIBUTE_GOLD = 4;
    
    // traits
    public const _ATTRIBUTE_TRAIT_START = 100;
    public const ATTRIBUTE_TRAIT_STRENGTH = 101;
    public const ATTRIBUTE_TRAIT_AGILITY = 102;
    public const ATTRIBUTE_TRAIT_ENDURANCE = 103;
    public const ATTRIBUTE_TRAIT_LUCK = 104;
    
    // inventory
    public const _ATTRIBUTE_INVENTORY_START = 200;
    public const _ATTRIBUTE_AMMO_START = 200;
    public const ATTRIBUTE_AMMO_DART = 201;
    public const ATTRIBUTE_AMMO_ARROW = 202;
    public const ATTRIBUTE_AMMO_BOLT = 203;
    public const ATTRIBUTE_AMMO_BULLET = 204;
    public const ATTRIBUTE_AMMO_CARTRIDGE = 205;
    public const ATTRIBUTE_AMMO_LOADER = 206;
    public const ATTRIBUTE_AMMO_EXPLOSIVE = 207;
    public const ATTRIBUTE_AMMO_NUCLEAR = 299;
    public const _ATTRIBUTE_WEAPON_START = 300;
    public const ATTRIBUTE_WEAPON_BLOWGUN = 301;
    public const ATTRIBUTE_WEAPON_BOW = 302;
    public const ATTRIBUTE_WEAPON_CROSSBOW = 303;
    public const ATTRIBUTE_WEAPON_GUN = 304;
    public const ATTRIBUTE_WEAPON_SHOTGUN = 305;
    public const ATTRIBUTE_WEAPON_MACHINEGUN = 306;
    public const ATTRIBUTE_WEAPON_LAUNCHER = 307;
    public const ATTRIBUTE_WEAPON_MININUKE = 399;
    public const _ATTRIBUTE_PROJECTILE_START = 400;
    public const ATTRIBUTE_PROJECTILE_STONE = 401;
    public const ATTRIBUTE_PROJECTILE_SMOKE = 402;
    public const ATTRIBUTE_PROJECTILE_FLASHBANG = 403;
    public const ATTRIBUTE_PROJECTILE_GRENADE = 404;
    public const ATTRIBUTE_PROJECTILE_MOLOTOV = 405;
    public const _ATTRIBUTE_UTILITY_START = 500;
    public const ATTRIBUTE_UTILITY_BANDAGE = 501;
    public const ATTRIBUTE_UTILITY_MEDIKIT = 502;
    public const ATTRIBUTE_UTILITY_PAINKILLER = 503;
    public const ATTRIBUTE_UTILITY_STEROID = 504;
    public const ATTRIBUTE_UTILITY_ANTIRAD = 599;
    public const _ATTRIBUTE_DEFENSE_START = 600;
    public const ATTRIBUTE_DEFENSE_JACKET = 601;
    public const ATTRIBUTE_DEFENSE_VEST = 602;
    public const ATTRIBUTE_DEFENSE_HELMET = 603;
    public const _ATTRIBUTE_CRAFT_START = 900;
    public const ATTRIBUTE_CRAFT_WOOD = 901;
    public const ATTRIBUTE_CRAFT_CLOTH = 902;
    public const ATTRIBUTE_CRAFT_LEATHER = 903;
    public const ATTRIBUTE_CRAFT_GLUE = 904;
    public const ATTRIBUTE_CRAFT_TAPE = 905;
    public const ATTRIBUTE_CRAFT_METAL_1 = 911;
    public const ATTRIBUTE_CRAFT_METAL_2 = 912;
    public const ATTRIBUTE_CRAFT_METAL_3 = 913;
    public const ATTRIBUTE_CRAFT_METAL_4 = 914;
    public const ATTRIBUTE_CRAFT_ELECTRONICS_1 = 921;
    public const ATTRIBUTE_CRAFT_ELECTRONICS_2 = 922;
    public const ATTRIBUTE_CRAFT_ELECTRONICS_3 = 923;
    public const ATTRIBUTE_CRAFT_ELECTRONICS_4 = 924;
    public const ATTRIBUTE_CRAFT_CHEMICALS_1 = 931;
    public const ATTRIBUTE_CRAFT_CHEMICALS_2 = 932;
    public const ATTRIBUTE_CRAFT_CHEMICALS_3 = 933;
    public const ATTRIBUTE_CRAFT_CHEMICALS_4 = 934;
    public const _ATTRIBUTE_INVENTORY_END = 999;
    
    // statistics
    public const _ATTRIBUTE_STAT_START = 1000;
    public const ATTRIBUTE_STAT_DEATHS = 1001;
    public const ATTRIBUTE_STAT_KILLS = 1002;
    public const ATTRIBUTE_STAT_DISTANCE = 1003;

    public static function getAttributeTypes(): array
    {
        return [
            self::ATTRIBUTE_HEALTH => '[-] Health',
            self::ATTRIBUTE_FATIGUE => '[-] Fatigue',
            self::ATTRIBUTE_MOVES => '[-] Moves',
            self::ATTRIBUTE_GOLD => '[-] Gold',
            //
            self::ATTRIBUTE_TRAIT_STRENGTH => '[T] Strength',
            self::ATTRIBUTE_TRAIT_AGILITY => '[T] Agility',
            self::ATTRIBUTE_TRAIT_ENDURANCE => '[T] Endurance',
            self::ATTRIBUTE_TRAIT_LUCK => '[T] Luck',
            //
            self::ATTRIBUTE_AMMO_DART => '[A] Darts',
            self::ATTRIBUTE_AMMO_ARROW => '[A] Arrows',
            self::ATTRIBUTE_AMMO_BOLT => '[A] Bolts',
            self::ATTRIBUTE_AMMO_BULLET => '[A] Bullets',
            self::ATTRIBUTE_AMMO_CARTRIDGE => '[A] Cartridges',
            self::ATTRIBUTE_AMMO_LOADER => '[A] Loaders',
            self::ATTRIBUTE_AMMO_EXPLOSIVE => '[A] Explosives',
            self::ATTRIBUTE_AMMO_NUCLEAR => '[A] Nuclear ogives',
            //
            self::ATTRIBUTE_WEAPON_BLOWGUN => '[W] Blowgun',
            self::ATTRIBUTE_WEAPON_BOW => '[W] Bow',
            self::ATTRIBUTE_WEAPON_CROSSBOW => '[W] Crossbow',
            self::ATTRIBUTE_WEAPON_GUN => '[W] Gun',
            self::ATTRIBUTE_WEAPON_SHOTGUN => '[W] Shotgun',
            self::ATTRIBUTE_WEAPON_MACHINEGUN => '[W] Machinegun',
            self::ATTRIBUTE_WEAPON_LAUNCHER => '[W] Launcher',
            self::ATTRIBUTE_WEAPON_MININUKE => '[W] Mini nuke',
            //
            self::ATTRIBUTE_PROJECTILE_STONE => '[P] Stones',
            self::ATTRIBUTE_PROJECTILE_SMOKE => '[P] Smoke bombs',
            self::ATTRIBUTE_PROJECTILE_FLASHBANG => '[P] Flash bangs',
            self::ATTRIBUTE_PROJECTILE_GRENADE => '[P] Grenades',
            self::ATTRIBUTE_PROJECTILE_MOLOTOV => '[P] Molotov',
            //
            self::ATTRIBUTE_UTILITY_BANDAGE => '[U] Bandages',
            self::ATTRIBUTE_UTILITY_MEDIKIT => '[U] Medikits',
            self::ATTRIBUTE_UTILITY_PAINKILLER => '[U] Pain killers',
            self::ATTRIBUTE_UTILITY_STEROID => '[U] Steroids',
            self::ATTRIBUTE_UTILITY_ANTIRAD => '[U] Antirads',
            //
            self::ATTRIBUTE_DEFENSE_JACKET => '[D] Reinforced jacket',
            self::ATTRIBUTE_DEFENSE_VEST => '[D] Bullet-proof vest',
            self::ATTRIBUTE_DEFENSE_HELMET => '[D] Helmet',
            //
            self::ATTRIBUTE_CRAFT_WOOD => '[C] Wood',
            self::ATTRIBUTE_CRAFT_CLOTH => '[C] Cloth',
            self::ATTRIBUTE_CRAFT_LEATHER => '[C] Leather',
            self::ATTRIBUTE_CRAFT_GLUE => '[C] Glue',
            self::ATTRIBUTE_CRAFT_TAPE => '[C] Tape',
            self::ATTRIBUTE_CRAFT_METAL_1 => '[C] Iron',
            self::ATTRIBUTE_CRAFT_METAL_2 => '[C] Copper',
            self::ATTRIBUTE_CRAFT_METAL_3 => '[C] Steel',
            self::ATTRIBUTE_CRAFT_METAL_4 => '[C] Aluminium',
            self::ATTRIBUTE_CRAFT_ELECTRONICS_1 => '[C] Discrete parts',
            self::ATTRIBUTE_CRAFT_ELECTRONICS_2 => '[C] Circuit boards',
            self::ATTRIBUTE_CRAFT_ELECTRONICS_3 => '[C] Chips',
            self::ATTRIBUTE_CRAFT_ELECTRONICS_4 => '[C] Switches',
            self::ATTRIBUTE_CRAFT_CHEMICALS_1 => '[C] Powder',
            self::ATTRIBUTE_CRAFT_CHEMICALS_2 => '[C] Acid',
            self::ATTRIBUTE_CRAFT_CHEMICALS_3 => '[C] Detergent',
            self::ATTRIBUTE_CRAFT_CHEMICALS_4 => '[C] Fertilizer',
            //
            self::ATTRIBUTE_STAT_DEATHS => '[S] Deaths',
            self::ATTRIBUTE_STAT_KILLS => '[S] Kills',
            self::ATTRIBUTE_STAT_DISTANCE => '[S] Distance',
        ];
    }
    
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
    private $attribute;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Adventurer::class, inversedBy="attributes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $adventurer;

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

    public function getAttribute(): ?int
    {
        return $this->attribute;
    }

    public function setAttribute(int $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

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
}
