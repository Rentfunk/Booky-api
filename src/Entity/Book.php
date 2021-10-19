<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[
    ApiResource(
        collectionOperations: ["get", "post"],
        itemOperations: ["get", "put"],
        denormalizationContext: [
            "groups" => ["book:write"]
        ],
        normalizationContext: [
            "groups" => ["book:read"]
        ]
    )
]
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 200)]
    #[Groups(["book:read", "book:write", "class_has_book:read", "teacher_has_book:read", "order:read", "order:write"])]
    #[Assert\NotBlank]
    private string $title;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["book:read", "book:write", "class_has_book:read", "teacher_has_book:read", "order:read", "order:write"])]
    #[Assert\NotBlank]
    private string $authors;

    #[ORM\ManyToMany(targetEntity: Grade::class)]
    #[Groups(["book:write", "order:write"])]
    #[Assert\Count(min: 1, minMessage: "Book should have assigned at least 1 grade")]
    private Collection $grades;

    #[ORM\OneToMany(mappedBy: "book", targetEntity: TeacherHasBook::class)]
    private Collection $teacherBookInfo;

    #[ORM\OneToMany(mappedBy: "book", targetEntity: ClassHasBook::class)]
    private Collection $classBookInfo;

    #[ORM\OneToMany(mappedBy: "book", targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->teacherBookInfo = new ArrayCollection();
        $this->classBookInfo = new ArrayCollection();
        $this->orders = new ArrayCollection();
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

    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    public function setAuthors(string $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    /** @return Collection<Grade> */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        $this->grades->removeElement($grade);

        return $this;
    }

    #[Groups("book:read")]
    public function getGradesText(): string
    {
        $gradesText = "";
        foreach ($this->getGrades() as $grade)
        {
            $gradesText .= $grade->getName().", ";
        }

        return substr($gradesText, 0, -2);
    }

    /** @return Collection<TeacherHasBook> */
    public function getTeacherBookInfo(): Collection
    {
        return $this->teacherBookInfo;
    }

    public function addTeacherBookInfo(TeacherHasBook $teacherBookInfo): self
    {
        if (!$this->teacherBookInfo->contains($teacherBookInfo)) {
            $this->teacherBookInfo[] = $teacherBookInfo;
            $teacherBookInfo->setBook($this);
        }

        return $this;
    }

    public function removeTeacherBookInfo(TeacherHasBook $teacherBookInfo): self
    {
        if ($this->teacherBookInfo->removeElement($teacherBookInfo)) {
            // set the owning side to null (unless already changed)
            if ($teacherBookInfo->getBook() === $this) {
                $teacherBookInfo->setBook(null);
            }
        }

        return $this;
    }

    #[Groups("book:read")]
    public function getGivenToTeachers(): int
    {
        $books = $this->getTeacherBookInfo();
        $booksCount = 0;

        foreach ($books as $book)
        {
            if ($book->getSchoolYear()->getIsCurrent()) {
                $booksCount += $book->getBooksOwned();
            }
        }

        return $booksCount;
    }

    #[Groups("book:read")]
    public function getReturnedFromTeachers(): int
    {
        $books = $this->getTeacherBookInfo();
        $booksCount = 0;

        foreach ($books as $book)
        {
            if ($book->getSchoolYear()->getIsCurrent()) {
                $booksCount += $book->getBooksReturned();
            }
        }

        return $booksCount;
    }

    /** @return Collection<ClassHasBook> */
    public function getClassBookInfo(): Collection
    {
        return $this->classBookInfo;
    }

    public function addClassBookInfo(ClassHasBook $classBookInfo): self
    {
        if (!$this->classBookInfo->contains($classBookInfo)) {
            $this->classBookInfo[] = $classBookInfo;
            $classBookInfo->setBook($this);
        }

        return $this;
    }

    public function removeClassBookInfo(ClassHasBook $classBookInfo): self
    {
        if ($this->classBookInfo->removeElement($classBookInfo)) {
            // set the owning side to null (unless already changed)
            if ($classBookInfo->getBook() === $this) {
                $classBookInfo->setBook(null);
            }
        }

        return $this;
    }

    #[Groups("book:read")]
    public function getGivenToStudents(): int
    {
        $booksCount = 0;
        foreach ($this->getClassBookInfo() as $book)
        {
            if ($book->getSchoolYear()->getIsCurrent()) {
                $booksCount += $book->getBooksOwned();
            }
        }

        return $booksCount;
    }

    #[Groups("book:read")]
    public function getReturnedFromStudents(): int
    {
        $booksCount = 0;
        foreach ($this->getClassBookInfo() as $book)
        {
            if ($book->getSchoolYear()->getIsCurrent()) {
                $booksCount += $book->getBooksReturned();
            }
        }

        return $booksCount;
    }

    /** @return Collection<Order> */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrders(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setBook($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getBook() === $this) {
                $order->setBook(null);
            }
        }

        return $this;
    }

    #[Groups("book:read")]
    public function getAmountInTotal(): int
    {
        $amountInTotal = 0;
        foreach ($this->getOrders() as $order)
        {
            $amountInTotal += $order->getBookQuantity();
        }

        return $amountInTotal;
    }

    #[Groups("book:read")]
    public function getAmountInStock(): int
    {
        return $this->getAmountInTotal() - $this->getGivenToStudents() - $this->getGivenToTeachers()
        + $this->getReturnedFromStudents() + $this->getReturnedFromTeachers();
    }
}
