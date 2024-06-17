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
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $cargo = null;

    #[ORM\ManyToOne(targetEntity: DetalleActividad::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?DetalleActividad $ponenteDetalleActividad = null;

    #[ORM\ManyToOne(targetEntity: Evento::class)]
    private ?Evento $evento = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(string $cargo): static
    {
        $this->cargo = $cargo;
        return $this;
    }

    public function getPonenteDetalleActividad(): ?DetalleActividad
    {
        return $this->ponenteDetalleActividad;
    }

    public function setPonenteDetalleActividad(?DetalleActividad $ponenteDetalleActividad): static
    {
        $this->ponenteDetalleActividad = $ponenteDetalleActividad;
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
