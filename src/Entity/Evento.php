<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titulo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $FechaInicio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $FechaFin = null;

    /**
     * @var Collection<int, Actividad>
     */
    #[ORM\OneToMany(targetEntity: Actividad::class, mappedBy: 'evento')]
    private Collection $evento_actividad;

    public function __construct()
    {
        $this->evento_actividad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->Titulo;
    }

    public function setTitulo(string $Titulo): static
    {
        $this->Titulo = $Titulo;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->FechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $FechaInicio): static
    {
        $this->FechaInicio = $FechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->FechaFin;
    }

    public function setFechaFin(\DateTimeInterface $FechaFin): static
    {
        $this->FechaFin = $FechaFin;

        return $this;
    }

    /**
     * @return Collection<int, Actividad>
     */
    public function getEventoActividad(): Collection
    {
        return $this->evento_actividad;
    }

    public function addEventoActividad(Actividad $eventoActividad): static
    {
        if (!$this->evento_actividad->contains($eventoActividad)) {
            $this->evento_actividad->add($eventoActividad);
            $eventoActividad->setEvento($this);
        }

        return $this;
    }

    public function removeEventoActividad(Actividad $eventoActividad): static
    {
        if ($this->evento_actividad->removeElement($eventoActividad)) {
            // set the owning side to null (unless already changed)
            if ($eventoActividad->getEvento() === $this) {
                $eventoActividad->setEvento(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitulo() ?? 'Sin Nombre'; 
    }
}
