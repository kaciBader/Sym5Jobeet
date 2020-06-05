<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name ="category")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Unique
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Job::class, mappedBy="category")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity=CategoryAffiliate::class, mappedBy="category")
     */
    private $category_affiliates;

    private $active_jobs;

    /**
    * Initializes a new Category.
    */
    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->category_affiliates = new ArrayCollection();
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
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->setCategory($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getCategory() === $this) {
                $job->setCategory(null);
            }
        }

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
            $categoryAffiliate->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryAffiliate(CategoryAffiliate $categoryAffiliate): self
    {
        if ($this->category_affiliates->contains($categoryAffiliate)) {
            $this->category_affiliates->removeElement($categoryAffiliate);
            // set the owning side to null (unless already changed)
            if ($categoryAffiliate->getCategory() === $this) {
                $categoryAffiliate->setCategory(null);
            }
        }

        return $this;
    }

    public function getActiveJobs()
    {
        return $this->active_jobs;
    }

    public function setActiveJobs($active_jobs): self
    {
        $this->active_jobs = $active_jobs;

        return $this;
    }
}
