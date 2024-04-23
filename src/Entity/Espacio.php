<?php

namespace App\Entity;

use App\Repository\EspacioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspacioRepository::class)]
class Espacio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Aforo = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\ManyToOne(inversedBy: 'espacios')]
    private ?Edificio $espacio_edificio = null;

    /**
     * @var Collection<int, Recurso>
     */
    #[ORM\ManyToMany(targetEntity: Recurso::class, mappedBy: 'recurso_espacio')]
    private Collection $recursos;

    /**
     * @var Collection<int, DetalleActividad>
     */
    #[ORM\OneToMany(targetEntity: DetalleActividad::class, mappedBy: 'detalle_actividad_espacios')]
    private Collection $detalleActividads;

    public function __construct()
    {
        $this->recursos = new ArrayCollection();
        $this->detalleActividads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAforo(): ?int
    {
        return $this->Aforo;
    }

    public function setAforo(int $Aforo): static
    {
        $this->Aforo = $Aforo;

        return $this;
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

    public function getEspacioEdificio(): ?Edificio
    {
        return $this->espacio_edificio;
    }

    public function setEspacioEdificio(?Edificio $espacio_edificio): static
    {
        $this->espacio_edificio = $espacio_edificio;

        return $this;
    }

    /**
     * @return Collection<int, Recurso>
     */
    public function getRecursos(): Collection
    {
        return $this->recursos;
    }

    public function addRecurso(Recurso $recurso): static
    {
        if (!$this->recursos->contains($recurso)) {
            $this->recursos->add($recurso);
            $recurso->addRecursoEspacio($this);
        }

        return $this;
    }

    public function removeRecurso(Recurso $recurso): static
    {
        if ($this->recursos->removeElement($recurso)) {
            $recurso->removeRecursoEspacio($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, DetalleActividad>
     */
    public function getDetalleActividads(): Collection
    {
        return $this->detalleActividads;
    }

    public function addDetalleActividad(DetalleActividad $detalleActividad): static
    {
        if (!$this->detalleActividads->contains($detalleActividad)) {
            $this->detalleActividads->add($detalleActividad);
            $detalleActividad->setDetalleActividadEspacios($this);
        }

        return $this;
    }

    public function removeDetalleActividad(DetalleActividad $detalleActividad): static
    {
        if ($this->detalleActividads->removeElement($detalleActividad)) {
            // set the owning side to null (unless already changed)
            if ($detalleActividad->getDetalleActividadEspacios() === $this) {
                $detalleActividad->setDetalleActividadEspacios(null);
            }
        }

        return $this;
    }
}
