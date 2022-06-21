<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EstablishmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: EstablishmentRepository::class)]
#[ApiResource(normalizationContext: ["groups" => ["establishment.read"]],denormalizationContext: ["groups" => ["user.write"]])]
class Establishment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["establishment.read"])]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["establishment.read", "establishment.write"])]
    private ?string $name;

    #[ORM\OneToMany(mappedBy: 'establishment', targetEntity: Order::class)]
    #[Groups(["establishment.read"])]
    private ArrayCollection $orders;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'establishments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["establishment.read", "establishment.write"])]
    private $owner;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["establishment.read"])]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(["establishment.read", "establishment.write"])]
    private $secteur;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(["establishment.read", "establishment.write"])]
    private $quartier;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(["establishment.read", "establishment.write"])]
    private $avenue;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(["establishment.read", "establishment.write"])]
    private $reference;

    #[ORM\Column(type: 'string', length: 10)]
    private $number;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->createdAt = new \DateTime();
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

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setEstablishment($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getEstablishment() === $this) {
                $order->setEstablishment(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getAvenue(): ?string
    {
        return $this->avenue;
    }

    public function setAvenue(string $avenue): self
    {
        $this->avenue = $avenue;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }
}
