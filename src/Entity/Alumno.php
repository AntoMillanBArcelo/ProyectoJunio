<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlumnoRepository::class)]
class Alumno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Correo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $FechaNac = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Grupo $alumno_grupo = null;

    /**
     * @var Collection<int, DetalleActividad>
     */
    #[ORM\ManyToMany(targetEntity: DetalleActividad::class, mappedBy: 'asiste')]
    private Collection $detalleActividads;

    public function __construct()
    {
        $this->detalleActividads = new ArrayCollection();
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

    public function getCorreo(): ?string
    {
        return $this->Correo;
    }

    public function setCorreo(string $Correo): static
    {
        $this->Correo = $Correo;

        return $this;
    }

    public function getFechaNac(): ?\DateTimeInterface
    {
        return $this->FechaNac;
    }

    public function setFechaNac(\DateTimeInterface $FechaNac): static
    {
        $this->FechaNac = $FechaNac;

        return $this;
    }

    public function getAlumnoGrupo(): ?Grupo
    {
        return $this->alumno_grupo;
    }

    public function setAlumnoGrupo(?Grupo $alumno_grupo): static
    {
        $this->alumno_grupo = $alumno_grupo;

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
            $detalleActividad->addAsiste($this);
        }

        return $this;
    }

    public function removeDetalleActividad(DetalleActividad $detalleActividad): static
    {
        if ($this->detalleActividads->removeElement($detalleActividad)) {
            $detalleActividad->removeAsiste($this);
        }

        return $this;
    }
}
