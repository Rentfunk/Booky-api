<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TeacherHasBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[
    ApiResource(
        collectionOperations: ["get", "post"],
        itemOperations: ["get", "put"],
        shortName: "TeacherBookCollection",
        denormalizationContext: [
            "groups" => ["teacher_has_book:write"]
        ],
        normalizationContext: [
            "groups" => ["teacher_has_book:read"]
        ]
    )
]
#[ORM\Entity(repositoryClass: TeacherHasBookRepository::class)]
#[ORM\UniqueConstraint(fields: ["teacher", "book"])]
class TeacherHasBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Teacher::class, inversedBy: "booksCollection")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["teacher_has_book:read", "teacher_has_book:write"])]
    private Teacher $teacher;

    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: "teacherBookInfo")]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["teacher_has_book:read", "teacher_has_book:write", "book:write"])]
    private Book $book;

    #[ORM\Column(type: "integer")]
    #[Groups(["teacher_has_book:read", "teacher_has_book:write"])]
    private int $booksOwned = 0;

    #[ORM\Column(type: "integer")]
    #[Groups(["teacher_has_book:read", "teacher_has_book:write"])]
    private int $booksReturned = 0;

    #[ORM\ManyToOne(targetEntity: SchoolYear::class)]
    #[ORM\JoinColumn(nullable: false)]
    private SchoolYear $schoolYear;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(Book $book): self
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
