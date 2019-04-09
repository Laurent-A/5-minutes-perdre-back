<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @Serializer\ExclusionPolicy("ALL")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $favorite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favorite_tag")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Quizz", inversedBy="tags")
     */
    private $quizz;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Wiki", inversedBy="tags")
     */
    private $wiki;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->quizz = new ArrayCollection();
        $this->wiki = new ArrayCollection();
        $this->favorite = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFavorite(): ?bool
    {
        return $this->favorite;
    }

    public function setFavorite(bool $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavoriteTag($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFavoriteTag($this);
        }

        return $this;
    }

    /**
     * @return Collection|Quizz[]
     */
    public function getQuizz(): Collection
    {
        return $this->quizz;
    }

    public function addQuizz(Quizz $quizz): self
    {
        if (!$this->quizz->contains($quizz)) {
            $this->quizz[] = $quizz;
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz): self
    {
        if ($this->quizz->contains($quizz)) {
            $this->quizz->removeElement($quizz);
        }

        return $this;
    }

    /**
     * @return Collection|Wiki[]
     */
    public function getWiki(): Collection
    {
        return $this->wiki;
    }

    public function addWiki(Wiki $wiki): self
    {
        if (!$this->wiki->contains($wiki)) {
            $this->wiki[] = $wiki;
        }

        return $this;
    }

    public function removeWiki(Wiki $wiki): self
    {
        if ($this->wiki->contains($wiki)) {
            $this->wiki->removeElement($wiki);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
