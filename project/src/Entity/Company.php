<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => ['company:list']]],
        'post' => [
            'security' => "is_granted('ROLE_ADMIN')",
            'security_message' => 'sorry, only admins can walk around here.',
            ],
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => ['company:list', 'show:client1', 'show:client2']]],
        'patch' => [
            'security' => "is_granted('ROLE_ADMIN')",
            'security_message' => 'sorry, only admins can walk around here.',
            ]],
    paginationEnabled: false,
)]
class Company implements UserIsInCompanyInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['show:client1', 'show:client2', 'company:list'])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 9)]
    private ?string $siren;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['show:client1', 'show:client2', 'company:list'])]
    private ?string $activityArea;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['show:client1', 'company:list'])]
    private ?string $address;

    #[ORM\Column(type: 'string', length: 10)]
    #[Groups(['show:client1', 'company:list'])]
    private ?string $zipCode;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['show:client1', 'company:list'])]
    private ?string $city;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['show:client1', 'company:list'])]
    private ?string $country;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['show:client1', 'company:list'])]
    private ?string $phoneNumber;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: User::class)]
    #[Groups(['admin:input', 'admin:output'])]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getActivityArea(): ?string
    {
        return $this->activityArea;
    }

    public function setActivityArea(?string $activityArea): self
    {
        $this->activityArea = $activityArea;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name.' - '.$this->city;
    }

    public function setUsers(): ?self
    {
        return $this;
    }
}
