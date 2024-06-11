<?php

namespace App\Entity;

use App\Repository\PonenteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PonenteRepository::class)]
class Ponente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $URL = null;

    #[ORM\Column(length: 255)]
    private ?string $CArgo = null;

    #[ORM\ManyToOne(inversedBy: 'ponentes')]
    private ?DetalleActividad $ponente_detalle_actividad = null;

    #[ORM\ManyToOne(targetEntity: Evento::class)]
    private ?Evento $evento = null;

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

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(string $URL): static
    {
        $this->URL = $URL;

        return $this;
    }

    public function getCArgo(): ?string
    {
        return $this->CArgo;
    }

    public function setCArgo(string $CArgo): static
    {
        $this->CArgo = $CArgo;

        return $this;
    }

    public function getPonenteDetalleActividad(): ?DetalleActividad
    {
        return $this->ponente_detalle_actividad;
    }

    public function setPonenteDetalleActividad(?DetalleActividad $ponente_detalle_actividad): static
    {
        $this->ponente_detalle_actividad = $ponente_detalle_actividad;

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
}
