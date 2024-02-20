<?php

namespace App\Entity;

use App\Repository\PlaneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaneRepository::class)]
class Plane
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Plane_num = null;

    #[ORM\Column(length: 255)]
    private ?string $company = null;

    #[ORM\Column(length: 255)]
    private ?string $num_place = null;

    #[ORM\OneToOne(mappedBy: 'plane', cascade: ['persist', 'remove'])]
    private ?Flight $flight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaneNum(): ?int
    {
        return $this->Plane_num;
    }

    public function setPlaneNum(int $Plane_num): static
    {
        $this->Plane_num = $Plane_num;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getNumPlace(): ?string
    {
        return $this->num_place;
    }

    public function setNumPlace(string $num_place): static
    {
        $this->num_place = $num_place;

        return $this;
    }

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(Flight $flight): static
    {
        // set the owning side of the relation if necessary
        if ($flight->getPlane() !== $this) {
            $flight->setPlane($this);
        }

        $this->flight = $flight;

        return $this;
    }
}
