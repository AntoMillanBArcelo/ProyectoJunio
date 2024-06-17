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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $URL = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: "detalleActividads")]
    #[ORM\JoinColumn(name: "detalle_actividad_evento_id", referencedColumnName: "id", nullable: false)]
    private ?Evento $evento = null;

    #[ORM\ManyToOne(targetEntity: Actividad::class, inversedBy: 'detalleActividads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Actividad $detalleActividadEvento = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_padre = null;

    /**
     * @var Collection<int, Grupo>
     */
    #[ORM\OneToMany(targetEntity: Grupo::class, mappedBy: 'detalleActividad')]
    private Collection $detalleActividad_grupo;

    public function __construct()
    {
        $this->asiste = new ArrayCollection();
        $this->ponentes = new ArrayCollection();
        $this->detalleActividad_grupo = new ArrayCollection();
        $this->espacios = new ArrayCollection();
        $this->detalleActividadEspacios = new ArrayCollection();
        $this->detalle_actividad_grupo = new ArrayCollection();
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
            if ($ponente->getPonenteDetalleActividad() === $this) {
                $ponente->setPonenteDetalleActividad(null);
            }
        }

        return $this;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
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

    public function getIdPadre(): ?int
    {
        return $this->id_padre;
    }

    public function setIdPadre(?int $id_padre): static
    {
        $this->id_padre = $id_padre;

        return $this;
    }

    /**
     * @return Collection<int, Grupo>
     */
    public function getDetalleActividadGrupo(): Collection
    {
        return $this->detalleActividad_grupo;
    }

    public function addDetalleActividadGrupo(Grupo $detalleActividadGrupo): static
    {
        if (!$this->detalleActividad_grupo->contains($detalleActividadGrupo)) {
            $this->detalleActividad_grupo->add($detalleActividadGrupo);
            $detalleActividadGrupo->setDetalleActividad($this);
        }

        return $this;
    }

    public function removeDetalleActividadGrupo(Grupo $detalleActividadGrupo): static
    {
        if ($this->detalleActividad_grupo->removeElement($detalleActividadGrupo)) {
            if ($detalleActividadGrupo->getDetalleActividad() === $this) {
                $detalleActividadGrupo->setDetalleActividad(null);
            }
        }

        return $this;
    }
    private $espacios;

    /**
     * @var Collection<int, Grupo>
     */
    #[ORM\ManyToMany(targetEntity: Grupo::class, inversedBy: 'detalleActividads')]
    private Collection $detalle_actividad_grupo;

   

    public function addEspacio(Espacio $espacio): self
    {
        if (!$this->espacios->contains($espacio)) {
            $this->espacios[] = $espacio;
        }

        return $this;
    }

    public function getEspacios()
    {
        return $this->espacios;
    }

}
