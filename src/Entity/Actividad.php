<?php

namespace App\Entity;

use App\Repository\ActividadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActividadRepository::class)]
class Actividad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaHoraIni = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaHoraFin = null;

    #[ORM\ManyToOne(inversedBy: 'evento_actividad')]
    private ?Evento $evento = null;

    /**
     * @var Collection<int, DetalleActividad>
     */
    #[ORM\OneToMany(targetEntity: DetalleActividad::class, mappedBy: 'detalle_actividad_evento')]
    private Collection $detalleActividads;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    public function __construct()
    {
        $this->detalleActividads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHoraIni(): ?\DateTimeInterface
    {
        return $this->FechaHoraIni;
    }

    public function setFechaHoraIni(\DateTimeInterface $FechaHoraIni): static
    {
        $this->FechaHoraIni = $FechaHoraIni;

        return $this;
    }

    public function getFechaHoraFin(): ?\DateTimeInterface
    {
        return $this->FechaHoraFin;
    }

    public function setFechaHoraFin(\DateTimeInterface $FechaHoraFin): static
    {
        $this->FechaHoraFin = $FechaHoraFin;

        return $this;
    }

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): static
    {
        $this->evento = $evento;

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
            $detalleActividad->setDetalleActividadEvento($this);
        }

        return $this;
    }

    public function removeDetalleActividad(DetalleActividad $detalleActividad): static
    {
        if ($this->detalleActividads->removeElement($detalleActividad)) {
            // set the owning side to null (unless already changed)
            if ($detalleActividad->getDetalleActividadEvento() === $this) {
                $detalleActividad->setDetalleActividadEvento(null);
            }
        }

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }
}
