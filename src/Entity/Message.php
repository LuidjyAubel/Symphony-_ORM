<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $texte;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity=theme::class, mappedBy="message", orphanRemoval=true)
     */
    private $theme;

    public function __construct()
    {
        $this->theme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|theme[]
     */
    public function getTheme(): Collection
    {
        return $this->theme;
    }

    public function addTheme(theme $theme): self
    {
        if (!$this->theme->contains($theme)) {
            $this->theme[] = $theme;
            $theme->setMessage($this);
        }

        return $this;
    }

    public function removeTheme(theme $theme): self
    {
        if ($this->theme->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getMessage() === $this) {
                $theme->setMessage(null);
            }
        }

        return $this;
    }
}
