<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[
    ApiResource(
        collectionOperations: ["get", "post"],
        itemOperations: ["get", "put"],
        denormalizationContext: [
            "groups" => ["order:write"]
        ],
        normalizationContext: [
            "groups" => ["order:read"]
        ]
    )
]
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: "`order`")]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Book::class, cascade: ["persist"], inversedBy: "orders")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["order:read", "order:write"])]
    private Book $book;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(["order:read", "order:write"])]
    private string $code;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(["order:read", "order:write"])]
    private string $isbn;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["order:read", "order:write"])]
    private string $registryNumber;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(["order:read", "order:write"])]
    private string $billingNumber;

    #[ORM\Column(type: "integer")]
    #[Groups(["order:read", "order:write"])]
    private int $bookQuantity = 0;

    #[ORM\Column(type: "float")]
    #[Groups(["order:read", "order:write"])]
    private float $pricePerBook;

    #[ORM\Column(type: "datetime")]
    #[Groups(["order:read"])]
    private \DateTimeInterface $orderedAt;

    #[ORM\Column(type: "integer", nullable: true)]
    private int $discardedQuantity;

    #[ORM\Column(type: "integer", nullable: true)]
    #[Groups(["order:read", "order:write"])]
    private int $publicationYear;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[Groups(["order:read", "order:write"])]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->orderedAt = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getRegistryNumber(): ?string
    {
        return $this->registryNumber;
    }

    public function setRegistryNumber(string $registryNumber): self
    {
        $this->registryNumber = $registryNumber;

        return $this;
    }

    public function getBillingNumber(): ?string
    {
        return $this->billingNumber;
    }

    public function setBillingNumber(?string $billingNumber): self
    {
        $this->billingNumber = $billingNumber;

        return $this;
    }

    public function getBookQuantity(): ?int
    {
        return $this->bookQuantity;
    }

    public function setBookQuantity(int $bookQuantity): self
    {
        $this->bookQuantity = $bookQuantity;

        return $this;
    }

    public function getPricePerBook(): ?float
    {
        return $this->pricePerBook;
    }

    public function setPricePerBook(float $pricePerBook): self
    {
        $this->pricePerBook = $pricePerBook;

        return $this;
    }

    public function getOrderedAt(): ?\DateTimeInterface
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(\DateTimeInterface $orderedAt): self
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    public function getDiscardedQuantity(): ?int
    {
        return $this->discardedQuantity;
    }

    public function setDiscardedQuantity(?int $discardedQuantity): self
    {
        $this->discardedQuantity = $discardedQuantity;

        return $this;
    }

    public function getPublicationYear(): ?int
    {
        return $this->publicationYear;
    }

    public function setPublicationYear(?int $publicationYear): self
    {
        $this->publicationYear = $publicationYear;

        return $this;
    }

    /** @return Collection<Tag> */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    #[Groups(["order:read"])]
    public function getTotalPrice(): float
    {
        return $this->getPricePerBook() * $this->getBookQuantity();
    }
}
