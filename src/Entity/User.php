<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation\PreSerialize;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\PostSerialize;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Serializer\ExclusionPolicy("ALL")
 */
class User implements UserInterface
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
     * @Serializer\Groups({"signup","quizz_score"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     * @Serializer\Expose
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=75)
     * @Serializer\Expose
     * @Serializer\Groups({"signup"})
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="users")
     */
    private $favorite_tag;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameScore", mappedBy="user")
     */
    private $gameScores;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuizzScore", mappedBy="user")
     */
    private $quizzScores;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quizz", mappedBy="author")
     */
    private $quizzs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wiki", mappedBy="author")
     */
    private $wikis;

    public function __construct()
    {
        $this->favorite_tag = new ArrayCollection();
        $this->gameScores = new ArrayCollection();
        $this->quizzScores = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->quizzs = new ArrayCollection();
        $this->wikis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

     /**
     * @PostSerialize
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

     /**
     * @PreSerialize
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getFavoriteTag(): Collection
    {
        return $this->favorite_tag;
    }

    public function addFavoriteTag(Tag $favoriteTag): self
    {
        if (!$this->favorite_tag->contains($favoriteTag)) {
            $this->favorite_tag[] = $favoriteTag;
        }

        return $this;
    }

    public function removeFavoriteTag(Tag $favoriteTag): self
    {
        if ($this->favorite_tag->contains($favoriteTag)) {
            $this->favorite_tag->removeElement($favoriteTag);
        }

        return $this;
    }

    /**
     * @return Collection|GameScore[]
     */
    public function getGameScores(): Collection
    {
        return $this->gameScores;
    }

    public function addGameScore(GameScore $gameScore): self
    {
        if (!$this->gameScores->contains($gameScore)) {
            $this->gameScores[] = $gameScore;
            $gameScore->setUser($this);
        }

        return $this;
    }

    public function removeGameScore(GameScore $gameScore): self
    {
        if ($this->gameScores->contains($gameScore)) {
            $this->gameScores->removeElement($gameScore);
            // set the owning side to null (unless already changed)
            if ($gameScore->getUser() === $this) {
                $gameScore->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QuizzScore[]
     */
    public function getQuizzScores(): Collection
    {
        return $this->quizzScores;
    }

    public function addQuizzScore(QuizzScore $quizzScore): self
    {
        if (!$this->quizzScores->contains($quizzScore)) {
            $this->quizzScores[] = $quizzScore;
            $quizzScore->setUser($this);
        }

        return $this;
    }

    public function removeQuizzScore(QuizzScore $quizzScore): self
    {
        if ($this->quizzScores->contains($quizzScore)) {
            $this->quizzScores->removeElement($quizzScore);
            // set the owning side to null (unless already changed)
            if ($quizzScore->getUser() === $this) {
                $quizzScore->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        //je recupere l'unique role attribué a mon utilisateur et je le set dans getRoles
        //attention getRole recupere un objet du type role , cependant on attend un tableau de chaine de caracteres
        return [$this->getRole()->getCode()]; // problem : le role est definit en dur dans cette fonction
    }
    
    public function getSalt(){}
    public function eraseCredentials(){}

        public function __toString()
        {
            return $this->username;
        }

        /**
         * @return Collection|Quizz[]
         */
        public function getQuizzs(): Collection
        {
            return $this->quizzs;
        }

        public function addQuizz(Quizz $quizz): self
        {
            if (!$this->quizzs->contains($quizz)) {
                $this->quizzs[] = $quizz;
                $quizz->setAuthor($this);
            }

            return $this;
        }

        public function removeQuizz(Quizz $quizz): self
        {
            if ($this->quizzs->contains($quizz)) {
                $this->quizzs->removeElement($quizz);
                // set the owning side to null (unless already changed)
                if ($quizz->getAuthor() === $this) {
                    $quizz->setAuthor(null);
                }
            }

            return $this;
        }

        /**
         * @return Collection|Wiki[]
         */
        public function getWikis(): Collection
        {
            return $this->wikis;
        }

        public function addWiki(Wiki $wiki): self
        {
            if (!$this->wikis->contains($wiki)) {
                $this->wikis[] = $wiki;
                $wiki->setAuthor($this);
            }

            return $this;
        }

        public function removeWiki(Wiki $wiki): self
        {
            if ($this->wikis->contains($wiki)) {
                $this->wikis->removeElement($wiki);
                // set the owning side to null (unless already changed)
                if ($wiki->getAuthor() === $this) {
                    $wiki->setAuthor(null);
                }
            }

            return $this;
        }
}

