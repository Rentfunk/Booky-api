<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClassHasBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[
    ApiResource(
        collectionOperations: ["get", "post"],
        itemOperations: ["get", "put"],
        shortName: "ClassroomBookCollection",
        denormalizationContext: [
            "groups" => ["class_has_book:write"]
        ],
        normalizationContext: [
            "groups" => ["class_has_book:read"]
        ]
    )
]
#[ORM\Entity(repositoryClass: ClassHasBookRepository::class)]
#[ORM\UniqueConstraint(fields: ["classroom", "book"])]
class ClassHasBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Classroom::class, inversedBy: "booksCollection")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["class_has_book:read", "class_has_book:write"])]
    private Classroom $classroom;

    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: "classBookInfo")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["class_has_book:read", "class_has_book:write", "classroom:write"])]
    private Book $book;

    #[ORM\Column(type: "integer")]
    #[Groups(["class_has_book:read", "class_has_book:write"])]
    private int $booksOwned;

    #[ORM\Column(type: "integer")]
    #[Groups(["class_has_book:read", "class_has_book:write"])]
    private int $booksReturned;

    #[ORM\ManyToOne(targetEntity: SchoolYear::class)]
    #[ORM\JoinColumn(nullable: false)]
    private SchoolYear $schoolYear;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getBooksOwned(): ?int
    {
        return $this->booksOwned;
    }

    public function setBooksOwned(int $booksOwned): self
    {
        $this->booksOwned = $booksOwned;

        return $this;
    }

    public function getBooksReturned(): ?int
    {
        return $this->booksReturned;
    }

    public function setBooksReturned(int $booksReturned): self
    {
        $this->booksReturned = $booksReturned;

        return $this;
    }

    public function getSchoolYear(): ?SchoolYear
    {
        return $this->schoolYear;
    }

    public function setSchoolYear(?SchoolYear $schoolYear): self
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }
}
