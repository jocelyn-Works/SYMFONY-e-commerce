<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez renseigner un nom.")]
    private ?string $name = null;

    #[ORM\Column(length: 855)]
    #[Assert\NotBlank(message: "Veuillez renseigner une description.")]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez renseigner un prix.")]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ImageProduct::class,
    orphanRemoval: true, cascade:['persist', 'remove'])]
    private Collection $images;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Category::class,
    orphanRemoval: true, cascade:['persist', 'remove'])]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Stock::class,
     orphanRemoval: true,  cascade:['persist', 'remove'])]
    private Collection $stocks;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Like::class,
     orphanRemoval: true,  cascade:['persist', 'remove'])]
        private Collection $likes;
    

    public function __construct()
    {
    
        $this->createdAt = new \DateTimeImmutable();
        $this->images = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->stocks = new ArrayCollection();
        
    }

    public function __toString()
    {
        return $this->name; // ou tout autre champ que vous souhaitez afficher
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImageProduct $productImage): static
    {
        if (!$this->images->contains($productImage)) {
            $this->images->add($productImage);
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeImage(ImageProduct $productImage): static
    {
        if ($this->images->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setProduct($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getProduct() === $this) {
                $category->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setProduct($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getProduct() === $this) {
                $stock->setProduct(null);
            }
        }

        return $this;
    }

     /**
     * @return Collection<int, Stock>
     */
    public function getlikes(): Collection
    {
        return $this->likes;
    }

    public function addlike(Stock $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setProduct($this);
        }

        return $this;
    }

    public function removelike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getProduct() === $this) {
                $like->setProduct(null);
            }
        }

        return $this;
    }

    
   
}
