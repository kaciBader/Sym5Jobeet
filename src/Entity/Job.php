<?php

namespace App\Entity;

use App\Repository\JobRepository;
use App\Utils\Jobeet as Jobeet;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JobRepository::class)
 *
 * @ORM\Table(name ="job")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

//  Assert\Choice(callback="getTypeValues")
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank
     *
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $location;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private $how_to_apply;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_public;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_activated;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     *
     * @Assert\Email(
     *   message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
    * @ORM\Column(type="datetime")
    */
    private $expires_at;


    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="jobs")
     *
     *@ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *
     * @Assert\NotBlank
     */
    private $category;

    /**
    * @Assert\Image
    */
    public $file; // used to upload files 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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

    public function getHowToApply(): ?string
    {
        return $this->how_to_apply;
    }

    public function setHowToApply(string $how_to_apply): self
    {
        $this->how_to_apply = $how_to_apply;

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

    public function getIsPublic(): ?bool
    {
        return $this->is_public;
    }

    public function setIsPublic(bool $is_public): self
    {
        $this->is_public = $is_public;

        return $this;
    }

    public function getIsActivated(): ?bool
    {
        return $this->is_activated;
    }

    public function setIsActivated(bool $is_activated): self
    {
        $this->is_activated = $is_activated;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expires_at;
    }

    public function setExpiresAt(\DateTimeInterface $expires_at): self
    {
        $this->expires_at = $expires_at;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

     /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
      if(!$this->getCreatedAt())
      {
        $this->created_at = new \DateTime();
      }
    }
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
      $this->updated_at = new \DateTime();
    }

    /**
    * Slugify company attribute
    *
    * @return string 
    */
    public function getCompanySlug()
    {
        return Jobeet::slugify($this->getCompany());
    }
 
 /*
    public function getAttributeSlug($att)
    {
        if()
    } */
    // penser a factoriser ces trois fonction en une seule 
    /**
    * Slugify position attribute
    *
    * @return string
    */
    public function getPositionSlug()
    {
        return Jobeet::slugify($this->getPosition());
    }
 
    /**
    * Slugify location attribute
    *
    * @return string 
    */
    public function getLocationSlug()
    {
        return Jobeet::slugify($this->getLocation());
    }

    public static function getTypes()
    {
        return array('full-time' => 'Full time', 'part-time' => 'Part time', 'freelance' => 'Freelance');
    }

    public static function getTypeValues()
    {
      return array_keys(self::getTypes());
    }

    protected function getUploadDir()
    {
        return 'uploads/jobs';
    }
 
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../public/vendor'.$this->getUploadDir();
    }
 
    public function getWebPath()
    {
        return null === $this->logo ? null : $this->getUploadDir().'/'.$this->logo;
    }
 
    public function getAbsolutePath()
    {
        return null === $this->logo ? null : $this->getUploadRootDir().'/'.$this->logo;
    }


    /**
     * @ORM\prePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->logo = uniqid().'.'.$this->file->guessExtension();
        }
    }

    /**
    * @ORM\PostPersist
    */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
     
          // if there is an error when moving the file, an exception will
          // be automatically thrown by move(). This will properly prevent
          // the entity from being persisted to the database on error
          $this->file->move($this->getUploadRootDir(), $this->logo);
         
          unset($this->file);
    }
 
    /**
    * @ORM\PostRemove
    */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}
