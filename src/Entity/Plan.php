<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanRepository")
 */
class Plan
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
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $blueprint;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Quotation", cascade={"persist", "remove"})
     */
    private $quotation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Project", cascade={"persist", "remove"})
     */
    private $project;





    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Module", mappedBy="plan", cascade={"persist", "remove"})
     */
    private $modules;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gamme", inversedBy="plans")
     */
    private $gamme;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->setDateCreation(new \DateTime());
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getQuotation(): ?Quotation
    {
        return $this->quotation;
    }

    public function setQuotation(?Quotation $quotation): self
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setPlan($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
            // set the owning side to null (unless already changed)
            if ($module->getPlan() === $this) {
                $module->setPlan(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlueprint()
    {
        return $this->blueprint;
    }

    /**
     * @param mixed $blueprint
     * @return Plan
     */
    public function setBlueprint($blueprint)
    {
        $this->blueprint = $blueprint;
        return $this;
    }

    public function getGamme(): ?Gamme
    {
        return $this->gamme;
    }

    public function setGamme(?Gamme $gamme): self
    {
        $this->gamme = $gamme;

        return $this;
    }



    public function __toString()
    {
        return $this->getName();
    }


}
