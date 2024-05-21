<?php

namespace App\Controller\Api;

use App\Entity\Alumno;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/alumnos")
 */
class AlumnoApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/", name="api_alumno_list", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Alumno::class);
        $alumnos = $repository->findAll();
        $data = [];
    
        foreach ($alumnos as $alumno) {
            $data[] = $this->serializeAlumno($alumno);
        }
    
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="api_alumno_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $alumno = $this->entityManager->getRepository(Alumno::class)->find($id);

        if (!$alumno) {
            return new JsonResponse(['message' => 'Alumno no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializeAlumno($alumno);

        return new JsonResponse($data, Response::HTTP_OK);
    }

     /**
     * @Route("/", name="api_alumno_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
     
        if (!isset($data['nombre']) || !isset($data['correo']) || !isset($data['fecha_nac'])) {
            return new JsonResponse(['message' => 'Nombre, correo y fecha de nacimiento son requeridos'], Response::HTTP_BAD_REQUEST);
        }

        $alumno = new Alumno();
        $alumno->setNombre($data['nombre'])
               ->setCorreo($data['correo'])
               ->setFechaNac(new \DateTime($data['fecha_nac']));

        $this->entityManager->persist($alumno);
        $this->entityManager->flush();

        $responseData = $this->serializeAlumno($alumno);
        return new JsonResponse($responseData, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_alumno_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $alumno = $this->entityManager->getRepository(Alumno::class)->find($id);

        if (!$alumno) {
            return new JsonResponse(['message' => 'Alumno no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($alumno);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function serializeAlumno(Alumno $alumno): array
    {
        return [
            'id' => $alumno->getId(),
            'nombre' => $alumno->getNombre(),
            'correo' => $alumno->getCorreo(),
            'fecha_nac' => $alumno->getFechaNac()->format('d-m-Y'),
        ];
    }
}
