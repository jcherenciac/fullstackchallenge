<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity()
 */
class Allocation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $share;

    /**
     * @ORM\ManyToOne(targetEntity=Portfolio::class, inversedBy="allocations")
     */
    private $portfolio;

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getShare()
    {
        return $this->share;
    }

    /**
     * @param mixed $share
     */
    public function setShare($share): void
    {
        $this->share = $share;
    }

    /**
     * @return mixed
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * @param mixed $portfolio
     */
    public function setPortfolio(Portfolio $portfolio): void
    {
        $this->portfolio = $portfolio;
    }

}