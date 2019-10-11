<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $length;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $width;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="modules")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Finition", inversedBy="modules")
     */
    private $finition;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Isolation", inversedBy="modules")
     */
    private $isolation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Coverage", inversedBy="modules")
     */
    private $coverage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Floor", inversedBy="modules")
     */
    private $floor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Structure", inversedBy="modules")
     */
    private $structure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plan", inversedBy="modules")
     */
    private $plan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(?float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFinition(): ?Finition
    {
        return $this->finition;
    }

    public function setFinition(?Finition $finition): self
    {
        $this->finition = $finition;

        return $this;
    }

    public function getIsolation(): ?Isolation
    {
        return $this->isolation;
    }

    public function setIsolation(?Isolation $isolation): self
    {
        $this->isolation = $isolation;

        return $this;
    }

    public function getCoverage(): ?Coverage
    {
        return $this->coverage;
    }

    public function setCoverage(?Coverage $coverage): self
    {
        $this->coverage = $coverage;

        return $this;
    }

    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    public function setFloor(?Floor $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(?Plan $plan): self
    {
        $this->plan = $plan;

        return $this;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }


    public function __toString()
    {
        return $this->getName();
    }

}
