<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     normalizationContext={"groups"={"teacher:read"}},
 *     denormalizationContext={"groups"={"teacher:write"}}
 * )
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */

class Teacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"teacher:read", "teacher:write", "teacher_has_book:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=TeacherHasBook::class, mappedBy="teacher")
     * @Groups({"teacher:read"})
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
     * @return Collection|TeacherHasBook[]
     */
    public function getBooksCollection(): Collection
    {
        return $this->booksCollection;
    }

    public function addBooksCollection(TeacherHasBook $booksCollection): self
    {
        if (!$this->booksCollection->contains($booksCollection)) {
            $this->booksCollection[] = $booksCollection;
            $booksCollection->setTeacher($this);
        }

        return $this;
    }

    public function removeBooksCollection(TeacherHasBook $booksCollection): self
    {
        if ($this->booksCollection->removeElement($booksCollection)) {
            // set the owning side to null (unless already changed)
            if ($booksCollection->getTeacher() === $this) {
                $booksCollection->setTeacher(null);
            }
        }

        return $this;
    }
}
