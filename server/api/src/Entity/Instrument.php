<?php

namespace App\Entity;

use App\Repository\InstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'instruments')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Composer::class, mappedBy: 'instrument')]
    private Collection $composers;

    #[ORM\Column(type: Types::ARRAY)]
    private array $level = [];

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->composers = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addInstrument($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeInstrument($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Composer>
     */
    public function getComposers(): Collection
    {
        return $this->composers;
    }

    public function addComposer(Composer $composer): self
    {
        if (!$this->composers->contains($composer)) {
            $this->composers->add($composer);
            $composer->addInstrument($this);
        }

        return $this;
    }

    public function removeComposer(Composer $composer): self
    {
        if ($this->composers->removeElement($composer)) {
            $composer->removeInstrument($this);
        }

        return $this;
    }

    public function getLevel(): array
    {
        return $this->level;
    }

    public function setLevel(array $level): self
    {
        $this->level = $level;

        return $this;
    }
}
