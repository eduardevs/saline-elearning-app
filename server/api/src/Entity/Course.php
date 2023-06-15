<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\User;
use App\Entity\Composer;


#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['course'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['course'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['course'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['course'])]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['course'])]
    private ?int $ratingScore = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $files = [];

    #[ORM\Column(length: 255)]
    #[Groups(['course'])]
    private ?string $linkVideo = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'courses')]
    #[Groups(['course_users'])]
    #[MaxDepth(1)]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'coursesGiven')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['course_professor'])]
    #[MaxDepth(1)]
    private ?User $professor = null;

    #[ORM\ManyToMany(targetEntity: Composer::class, inversedBy: 'courses')]
    #[Groups(['course_composers'])]
    #[MaxDepth(1)]
    private Collection $composers;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'course')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instrument $instrument = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->composers = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRatingScore(): ?int
    {
        return $this->ratingScore;
    }

    public function setRatingScore(?int $ratingScore): self
    {
        $this->ratingScore = $ratingScore;

        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setFiles(?array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function getLinkVideo(): ?string
    {
        return $this->linkVideo;
    }

    public function setLinkVideo(string $linkVideo): self
    {
        $this->linkVideo = $linkVideo;

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
            $user->addCourse($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCourse($this);
        }

        return $this;
    }

    public function getProfessor(): ?User
    {
        return $this->professor;
    }

    public function setProfessor(?User $professor): self
    {
        $this->professor = $professor;

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
        }

        return $this;
    }

    public function removeComposer(Composer $composer): self
    {
        $this->composers->removeElement($composer);

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addCourse($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeCourse($this);
        }

        return $this;
    }

    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(?Instrument $instrument): self
    {
        $this->instrument = $instrument;

        return $this;
    }
}
