<?php

namespace App\Entity;

use App\Repository\AdressUserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressUserRepository::class)]
class AdressUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'AdressUsers')]
    private ?User $author = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez renseigner un Pays.")]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s]*$/',
        message: 'Le champ peut contenir que des lettres majuscules, minuscules et des chiffres.'
    )]
    #[Assert\NotBlank(message: "Veuillez renseigner une Adresse.")]
    #[Assert\Length(min: 10, minMessage:" L'adresse doit faire plus de 5 caracteres.")]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^[0-9]*$/',
        message: 'Le champ peut contenir que des chiffres.'
    )] 
    #[Assert\NotBlank(message: "Veuillez renseigner un code postale.")]
    #[Assert\Length(min: 3, minMessage:" Le code postale doit faire plus de 3 caracteres.")]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z\s]*$/',
        message: 'Le champ peut contenir des lettres majuscules et minuscules .'
    )]
    #[Assert\NotBlank(message: "Veuillez renseigner une ville.")]
    #[Assert\Length(min: 3, minMessage:" La ville doit faire plus de 3 caracteres.")]
    private ?string $city = null;

    #[ORM\Column(length: 50)]
    #[Assert\Regex(
        pattern: '/^[0-9]*$/',
        message: 'Le champ peut contenir que des chiffres .'
    )] 
    #[Assert\NotBlank(message: "Veuillez renseigner un numéros de télephone.")]
    #[Assert\Length(min: 5, minMessage:" Le numéros de télephone doit faire plus de 5 caracteres.")]
    private ?string $phone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    public function __toString(): string
    {
        return $this->getAuthor(); 
    }

        
    public function __construct()
    {
    
        $this->createdAt = new \DateTimeImmutable();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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

    
}
