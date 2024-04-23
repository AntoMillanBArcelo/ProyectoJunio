<?php

namespace App\Entity;

use App\Repository\GrupoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GrupoRepository::class)]
class Grupo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    /**
     * @var Collection<int, Alumno>
     */
    #[ORM\OneToMany(targetEntity: Alumno::class, mappedBy: 'alumno_grupo')]
    private Collection $alumnos;

    /**
     * @var Collection<int, NivelEducativo>
     */
    #[ORM\OneToMany(targetEntity: NivelEducativo::class, mappedBy: 'grupo')]
    private Collection $grupo_niveleducativo;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'grupos')]
    private Collection $grupo_user;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->grupo_niveleducativo = new ArrayCollection();
        $this->grupo_user = new ArrayCollection();
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

    /**
     * @return Collection<int, Alumno>
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(Alumno $alumno): static
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos->add($alumno);
            $alumno->setAlumnoGrupo($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): static
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getAlumnoGrupo() === $this) {
                $alumno->setAlumnoGrupo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NivelEducativo>
     */
    public function getGrupoNiveleducativo(): Collection
    {
        return $this->grupo_niveleducativo;
    }

    public function addGrupoNiveleducativo(NivelEducativo $grupoNiveleducativo): static
    {
        if (!$this->grupo_niveleducativo->contains($grupoNiveleducativo)) {
            $this->grupo_niveleducativo->add($grupoNiveleducativo);
            $grupoNiveleducativo->setGrupo($this);
        }

        return $this;
    }

    public function removeGrupoNiveleducativo(NivelEducativo $grupoNiveleducativo): static
    {
        if ($this->grupo_niveleducativo->removeElement($grupoNiveleducativo)) {
            // set the owning side to null (unless already changed)
            if ($grupoNiveleducativo->getGrupo() === $this) {
                $grupoNiveleducativo->setGrupo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getGrupoUser(): Collection
    {
        return $this->grupo_user;
    }

    public function addGrupoUser(User $grupoUser): static
    {
        if (!$this->grupo_user->contains($grupoUser)) {
            $this->grupo_user->add($grupoUser);
        }

        return $this;
    }

    public function removeGrupoUser(User $grupoUser): static
    {
        $this->grupo_user->removeElement($grupoUser);

        return $this;
    }
}
