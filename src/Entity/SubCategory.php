<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Veuillez renseigner un nom.")]
    private ?string $name = null;

    // #[ORM\OneToMany(mappedBy: 'subCategory', targetEntity: Category::class)]
    // private Collection $categories;

    // public function __construct()
    // {
    //     $this->categories = new ArrayCollection();
    // }
    

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

    // /**
    //  * @return Collection<int, Category>
    //  */
    // public function getCategories(): Collection
    // {
    //     return $this->categories;
    // }

    // public function addCategory(Category $category): static
    // {
    //     if (!$this->categories->contains($category)) {
    //         $this->categories->add($category);
    //         $category->setSubCategory($this);
    //     }

    //     return $this;
    // }

    // public function removeCategory(Category $category): static
    // {
    //     if ($this->categories->removeElement($category)) {
    //         // set the owning side to null (unless already changed)
    //         if ($category->getSubCategory() === $this) {
    //             $category->setSubCategory(null);
    //         }
    //     }

    //     return $this;
    // }
}
