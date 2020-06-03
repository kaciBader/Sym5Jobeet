<?php

namespace App\Entity;

use App\Repository\AffiliateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AffiliateRepository::class)
 *
 * @ORM\Table(name="affiliate")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Affiliate
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
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=CategoryAffiliate::class, mappedBy="affiliate")
     */
    private $category_affiliates;

    /**
    * Initializes a new Affiliate.
    */
    public function __construct()
    {
        $this->category_affiliates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|CategoryAffiliate[]
     */
    public function getCategoryAffiliates(): Collection
    {
        return $this->category_affiliates;
    }

    public function addCategoryAffiliate(CategoryAffiliate $categoryAffiliate): self
    {
        if (!$this->category_affiliates->contains($categoryAffiliate)) {
            $this->category_affiliates[] = $categoryAffiliate;
            $categoryAffiliate->setAffiliate($this);
        }

        return $this;
    }

    public function removeCategoryAffiliate(CategoryAffiliate $categoryAffiliate): self
    {
        if ($this->category_affiliates->contains($categoryAffiliate)) {
            $this->category_affiliates->removeElement($categoryAffiliate);
            // set the owning side to null (unless already changed)
            if ($categoryAffiliate->getAffiliate() === $this) {
                $categoryAffiliate->setAffiliate(null);
            }
        }

        return $this;
    }

    /**
    * @ORM\PrePersist
    */
    public function setCreatedAtValue()
    {
      $this->created_at = new \DateTime();
    }
}
