<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity()
 */
//repositoryClass="App\Repository\PortfolioRepository"
class Portfolio
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Allocation::class, mappedBy="portfolio")
     */
    private $allocations;

    public function __construct()
    {
        $this->allocations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Allocation[]
     */
    public function getAllocations(): Collection
    {
        return $this->allocations;
    }

    public function addAllocation(Allocation $allocation): self
    {
        if (!$this->allocations->contains($allocation)) {
            $this->allocations[] = $allocation;
            $allocation->setPortfolio($this);
        }

        return $this;
    }

    public function removeAllocation(Allocation $allocation): self
    {
        if ($this->allocations->contains($allocation)) {
            $this->allocations->removeElement($allocation);
            // set the owning side to null (unless already changed)
            if ($allocation->getPortfolio() === $this) {
                $allocation->setPortfolio(null);
            }
        }

        return $this;
    }

}