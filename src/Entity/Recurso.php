<?php

namespace App\Entity;

use App\Repository\RecursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecursoRepository::class)]
class Recurso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Descripcion = null;

    /**
     * @var Collection<int, Espacio>
     */
    #[ORM\ManyToMany(targetEntity: Espacio::class, inversedBy: 'recursos')]
    private Collection $recurso_espacio;

    public function __construct()
    {
        $this->recurso_espacio = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(string $Descripcion): static
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Espacio>
     */
    public function getRecursoEspacio(): Collection
    {
        return $this->recurso_espacio;
    }

    public function addRecursoEspacio(Espacio $recursoEspacio): static
    {
        if (!$this->recurso_espacio->contains($recursoEspacio)) {
            $this->recurso_espacio->add($recursoEspacio);
        }

        return $this;
    }

    public function removeRecursoEspacio(Espacio $recursoEspacio): static
    {
        $this->recurso_espacio->removeElement($recursoEspacio);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getDescripcion() ?? 'Sin Nombre'; 
    }
}
