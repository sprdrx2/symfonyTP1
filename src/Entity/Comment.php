<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ClientName;

    /**
     * @ORM\Column(type="text")
     */
    private $Text;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="comments")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->ClientName;
    }

    public function setClientName(string $ClientName): self
    {
        $this->ClientName = $ClientName;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->product = $Product;

        return $this;
    }
}
