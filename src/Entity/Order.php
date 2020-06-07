<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $portfolio;

    /**
     * @ORM\Column(type="integer")
     */
    private $allocation;

    /**
     * @ORM\Column(type="integer")
     */
    private $shares;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortfolio(): ?int
    {
        return $this->portfolio;
    }

    public function setPortfolio(int $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getAllocation(): ?int
    {
        return $this->allocation;
    }

    public function setAllocation(int $allocation): self
    {
        $this->allocation = $allocation;

        return $this;
    }

    public function getShares(): ?int
    {
        return $this->shares;
    }

    public function setShares(int $shares): self
    {
        $this->shares = $shares;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
