<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PopularVoteRepository")
 */
class PopularVote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verdict;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVerdict(): ?bool
    {
        return $this->verdict;
    }

    public function setVerdict(bool $verdict): self
    {
        $this->verdict = $verdict;

        return $this;
    }

   /**
    * @ORM\ManyToOne(targetEntity="Product", inversedBy="popularVotes")
    * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
    */
    private $product;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
