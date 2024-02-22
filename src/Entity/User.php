<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: 'email', message: "Cet email est déjà utilisé.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Veuillez renseigner une adresse mail.")]
    #[Assert\Email(message: "Veuillez renseigner une adresse mail valide.")]
    private ?string $email = null;
    
    #[ORM\Column]
    private array $roles = [];
    
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9!@#$%^&*(),.?:{}|]*$/',
        message: 'Le champ peut contenir des lettres majuscules, minuscules, chiffres et certains symboles.'
        )] 
        #[Assert\NotBlank(message: "Veuillez renseigner un mot de passe.")]
        #[Assert\Length(min: 5, minMessage:" Le mot de passe doit faire plus de 5 caracteres.")]
        private ?string $password = null;
        
        #[ORM\Column(length: 255)]
        #[Assert\NotBlank(message: "Veuillez renseigner votre prénom.")]
        private ?string $firstname = null;
        
        #[ORM\Column(length: 255)]
        #[Assert\NotBlank(message: "Veuillez renseigner votr nom.")]
        private ?string $lastname = null;
        
        #[ORM\Column(type: Types::DATE_MUTABLE)]
        private ?\DateTimeInterface $birthdate = null;

        #[ORM\Column]
        private ?\DateTimeImmutable $createdAt = null;
        
        #[ORM\OneToMany(mappedBy: 'author', targetEntity: AdressUser::class)]
        private Collection $AdressUsers;
        
        #[ORM\Column(nullable: true)]
        private ?\DateTimeImmutable $updatedAt = null;
        
        #[ORM\Column()]
        #[Assert\NotBlank(message: "Veuillez accepter les condition.")]
        private ?bool $condition_user = null;


   

    public function __toString(): string
    {
        return $this->getFullname(); 
    }

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTimeImmutable();
        $this->AdressUsers = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullname() : string {
        return $this->firstname . ' ' .$this->lastname;
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

    /**
     * @return Collection<int, DescriptionUser>
     */
    public function getAdressUsers(): Collection
    {
        return $this->AdressUsers;
    }

    public function addAdressUser(AdressUser $AdressUser): static
    {
        if (!$this->AdressUsers->contains($AdressUser)) {
            $this->AdressUsers->add($AdressUser);
            $AdressUser->setAuthor($this);
        }

        return $this;
    }

    public function removeAdressUser(AdressUser $AdressUser): static
    {
        if ($this->AdressUsers->removeElement($AdressUser)) {
            // set the owning side to null (unless already changed)
            if ($AdressUser->getAuthor() === $this) {
                $AdressUser->setAuthor(null);
            }
        }

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

    public function getConditionUser(): ?bool
    {
        return $this->condition_user;
    }

    public function setConditionUser(?bool $condition_user): static
    {
        $this->condition_user = $condition_user;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthDate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    


    
}
