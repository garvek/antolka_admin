<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\Table(
 *   indexes={
 *     @ORM\Index(name="type_idx", columns={"type"}),
 *     @ORM\Index(name="type_tag_idx", columns={"type","tag"}),
 *     @ORM\Index(name="published_idx", columns={"published"})
 * })
 */
class Message
{
    public const TYPE_GLOBAL = 0;
    public const TYPE_REGION = 1;
    public const TYPE_ZONE = 2;
    public const TYPE_AREA = 3;
    public const TYPE_DIRECT = 4;
    public const TYPE_SPECIAL = 5;

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
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $tag;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=MessageRecipient::class, mappedBy="message")
     */
    private $recipients;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function __toString(): string
    {
        return ($this->title ?? 'Untitled') . ' (' . $this->getId() . ')';
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function getTag(): ?int
    {
        return $this->tag;
    }

    public function setTag(int $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|MessageRecipient[]
     */
    public function getRecipients(): Collection
    {
        return $this->recipients;
    }

    public function addRecipient(MessageRecipient $recipient): self
    {
        if (!$this->recipients->contains($recipient)) {
            $this->recipients[] = $recipient;
            $recipient->setMessage($this);
        }

        return $this;
    }

    public function removeRecipient(MessageRecipient $recipient): self
    {
        if ($this->recipients->removeElement($recipient)) {
            // set the owning side to null (unless already changed)
            if ($recipient->getMessage() === $this) {
                $recipient->setMessage(null);
            }
        }

        return $this;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }
}
