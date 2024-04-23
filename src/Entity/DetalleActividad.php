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

    public function __construct()
    {
        $this->asiste = new ArrayCollection();
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

    
}
