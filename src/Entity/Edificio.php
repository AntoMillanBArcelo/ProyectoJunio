<?php

namespace App\Entity;

use App\Repository\EdificioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EdificioRepository::class)]
class Edificio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    /**
     * @var Collection<int, Espacio>
     */
    #[ORM\OneToMany(targetEntity: Espacio::class, mappedBy: 'espacio_edificio')]
    private Collection $espacios;

    public function __construct()
    {
        $this->espacios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    /**
     * @return Collection<int, Espacio>
     */
    public function getEspacios(): Collection
    {
        return $this->espacios;
    }

    public function addEspacio(Espacio $espacio): static
    {
        if (!$this->espacios->contains($espacio)) {
            $this->espacios->add($espacio);
            $espacio->setEspacioEdificio($this);
        }

        return $this;
    }

    public function removeEspacio(Espacio $espacio): static
    {
        if ($this->espacios->removeElement($espacio)) {
            // set the owning side to null (unless already changed)
            if ($espacio->getEspacioEdificio() === $this) {
                $espacio->setEspacioEdificio(null);
            }
        }

        return $this;
    }
}
