<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TeacherHasBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     normalizationContext={"groups"={"teacher_has_book:read"}},
 *     denormalizationContext={"groups"={"teacher_has_book:write"}},
 *     shortName="TeacherBookCollection"
 * )
 * @ORM\Entity(repositoryClass=TeacherHasBookRepository::class)
 * @ORM\Table(
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(fields={"teacher", "book"})
 *     }
 * )
 */

class TeacherHasBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="booksCollection")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"teacher_has_book:read", "teacher_has_book:write"})
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="teacherBookInfo")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"teacher_has_book:read", "teacher_has_book:write", "book:write"})
     */
    private $book;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"teacher_has_book:read", "teacher_has_book:write"})
     */
    private $booksOwned = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"teacher_has_book:read", "teacher_has_book:write"})
     */
    private $booksReturned = 0;

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
}
