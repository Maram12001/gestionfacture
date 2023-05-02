<?php

namespace App\Entity;

use App\Repository\FactureClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureClientRepository::class)]
class FactureClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEcheance = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmission = null;

    #[ORM\Column]
    private ?bool $etatComptable = null;

    #[ORM\Column(nullable: true)]
    private ?string $paiement = null;

    #[ORM\Column(nullable: true)]
    private ?string $livraison = null;

    #[ORM\ManyToOne(inversedBy: 'factureClients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'factureClient', targetEntity: LigneProduitClient::class)]
    private Collection $ligneProduitClients;

    public function __construct()
    {
        $this->ligneProduitClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEcheance(): ?\DateTimeInterface
    {
        return $this->dateEcheance;
    }

    public function setDateEcheance(\DateTimeInterface $dateEcheance): self
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->dateEmission;
    }

    public function setDateEmission(\DateTimeInterface $dateEmission): self
    {
        $this->dateEmission = $dateEmission;

        return $this;
    }

    public function isEtatComptable(): ?bool
    {
        return $this->etatComptable;
    }

    public function setEtatComptable(bool $etatComptable): self
    {
        $this->etatComptable = $etatComptable;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, LigneProduitClient>
     */
    public function getLigneProduitClients(): Collection
    {
        return $this->ligneProduitClients;
    }

    public function addLigneProduitClient(LigneProduitClient $ligneProduitClient): self
    {
        if (!$this->ligneProduitClients->contains($ligneProduitClient)) {
            $this->ligneProduitClients->add($ligneProduitClient);
            $ligneProduitClient->setFactureClient($this);
        }

        return $this;
    }

    public function removeLigneProduitClient(LigneProduitClient $ligneProduitClient): self
    {
        if ($this->ligneProduitClients->removeElement($ligneProduitClient)) {
            // set the owning side to null (unless already changed)
            if ($ligneProduitClient->getFactureClient() === $this) {
                $ligneProduitClient->setFactureClient(null);
            }
        }

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTva(): ?float
    {
        return $this->tva;
    }

    /**
     * @param float|null $tva
     */
    public function setTva(?float $tva): void
    {
        $this->tva = $tva;
    }

    /**
     * @return string|null
     */
    public function getPaiement(): ?string
    {
        return $this->paiement;
    }

    /**
     * @param string|null $paiement
     */
    public function setPaiement(?string $paiement): void
    {
        $this->paiement = $paiement;
    }

    /**
     * @return string|null
     */
    public function getLivraison(): ?string
    {
        return $this->livraison;
    }

    /**
     * @param string|null $livraison
     */
    public function setLivraison(?string $livraison): void
    {
        $this->livraison = $livraison;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
