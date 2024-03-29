<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Rayon", inversedBy="products")
     * @ORM\JoinColumn(name="rayon_id", referencedColumnName="id")
     */
    private $rayon;

   /**
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="product")
    */
 
    private $comments;
    
    /**
     * @ORM\OneToMany(targetEntity="PopularVote", mappedBy="product")
     */
    private $popularVotes;

   private $popularVotesOK = 0;
   private $popularVotesNOK = 0;
   private $popularVotesCalculated = FALSE;

   public function __construct() {
	   $this->comments = new ArrayCollection();
	   $this->popularVotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRayon(): ?Rayon
    {
        return $this->rayon;
    }

    public function setRayon(?Rayon $rayon): self
    {
        $this->rayon = $rayon;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    public function getSlug(): string {
	return str_replace(' ', '-', $this->title);
    }

    /**
     * @return Collection|PopularVote[]
     */
    public function getPopularVotes(): Collection
    {
        return $this->popularVotes;
    }

    public function addPopularVote(PopularVote $popularVote): self
    {
        if (!$this->popularVotes->contains($popularVote)) {
            $this->popularVotes[] = $popularVote;
            $popularVote->setProduct($this);
        }

        return $this;
    }

    public function removePopularVote(PopularVote $popularVote): self
    {
        if ($this->popularVotes->contains($popularVote)) {
            $this->popularVotes->removeElement($popularVote);
            // set the owning side to null (unless already changed)
            if ($popularVote->getProduct() === $this) {
                $popularVote->setProduct(null);
            }
        }

        return $this;
    }

    public function calculatePopularVotesResults() {
	    foreach($this->popularVotes as $vote) {
		if($vote->getVerdict() == TRUE) {
			$this->popularVotesOK++;
		} else {
			$this->popularVotesNOK++;
		}
	    }
	    $this->popularVotesCalculated = TRUE;	    
    }  

    public function getPopularVotesOK(): int {
	    if(!$this->popularVotesCalculated) { $this->calculatePopularVotesResults(); }
	    return $this->popularVotesOK;
    }
    public function getPopularVotesNOK(): int { 
	    if(!$this->popularVotesCalculated) { $this->calculatePopularVotesResults(); }
	    return $this->popularVotesNOK;   
    }    
}
