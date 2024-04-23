<?php

namespace App\Entity;

use App\Repository\DetalleActividadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleActividadRepository::class)]
class DetalleActividad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaHoraIni = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaHoraFin = null;

    #[ORM\Column(length: 255)]
    private ?string $Titulo = null;

    /**
     * @var Collection<int, Alumno>
     */
    #[ORM\ManyToMany(targetEntity: Alumno::class, inversedBy: 'detalleActividads')]
    private Collection $asiste;

    #[ORM\ManyToOne(inversedBy: 'detalleActividads')]
    private ?Espacio $detalle_actividad_espacios = null;

    /**
     * @var Collection<int, Ponente>
     */
    #[ORM\OneToMany(targetEntity: Ponente::class, mappedBy: 'ponente_detalle_actividad')]
    private Collection $ponentes;

    #[ORM\ManyToOne(inversedBy: 'detalleActividads')]
    private ?Actividad $detalle_actividad_evento = null;

    public function __construct()
    {
        $this->asiste = new ArrayCollection();
        $this->ponentes = new ArrayCollection();
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

    public function getTitulo(): ?string
    {
        return $this->Titulo;
    }

    public function setTitulo(string $Titulo): static
    {
        $this->Titulo = $Titulo;

        return $this;
    }

    /**
     * @return Collection<int, Alumno>
     */
    public function getAsiste(): Collection
    {
        return $this->asiste;
    }

    public function addAsiste(Alumno $asiste): static
    {
        if (!$this->asiste->contains($asiste)) {
            $this->asiste->add($asiste);
        }

        return $this;
    }

    public function removeAsiste(Alumno $asiste): static
    {
        $this->asiste->removeElement($asiste);

        return $this;
    }

    public function getDetalleActividadEspacios(): ?Espacio
    {
        return $this->detalle_actividad_espacios;
    }

    public function setDetalleActividadEspacios(?Espacio $detalle_actividad_espacios): static
    {
        $this->detalle_actividad_espacios = $detalle_actividad_espacios;

        return $this;
    }

    /**
     * @return Collection<int, Ponente>
     */
    public function getPonentes(): Collection
    {
        return $this->ponentes;
    }

    public function addPonente(Ponente $ponente): static
    {
        if (!$this->ponentes->contains($ponente)) {
            $this->ponentes->add($ponente);
            $ponente->setPonenteDetalleActividad($this);
        }

        return $this;
    }

    public function removePonente(Ponente $ponente): static
    {
        if ($this->ponentes->removeElement($ponente)) {
            // set the owning side to null (unless already changed)
            if ($ponente->getPonenteDetalleActividad() === $this) {
                $ponente->setPonenteDetalleActividad(null);
            }
        }

        return $this;
    }

    public function getDetalleActividadEvento(): ?Actividad
    {
        return $this->detalle_actividad_evento;
    }

    public function setDetalleActividadEvento(?Actividad $detalle_actividad_evento): static
    {
        $this->detalle_actividad_evento = $detalle_actividad_evento;

        return $this;
    }

    
}
