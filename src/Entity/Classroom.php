<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     normalizationContext={"groups"={"classroom:read"}},
 *     denormalizationContext={"groups"={"classroom:write"}}
 * )
 * @ORM\Entity(repositoryClass=ClassroomRepository::class)
 */

class Classroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Grade::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"classroom:read", "classroom:write"})
     * @Assert\NotBlank()
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"classroom:read", "classroom:write", "class_has_book:read"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ClassHasBook::class, mappedBy="classroom")
     * @Groups({"classroom:read"})
     */
    private $booksCollection;

    public function __construct()
    {
        $this->booksCollection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
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
     * @return Collection|ClassHasBook[]
     */
    public function getBooksCollection(): Collection
    {
        return $this->booksCollection;
    }

    public function addBooksCollection(ClassHasBook $booksCollection): self
    {
        if (!$this->booksCollection->contains($booksCollection)) {
            $this->booksCollection[] = $booksCollection;
            $booksCollection->setClassroom($this);
        }

        return $this;
    }

    public function removeBooksCollection(ClassHasBook $booksCollection): self
    {
        if ($this->booksCollection->removeElement($booksCollection)) {
            // set the owning side to null (unless already changed)
            if ($booksCollection->getClassroom() === $this) {
                $booksCollection->setClassroom(null);
            }
        }

        return $this;
    }
}
