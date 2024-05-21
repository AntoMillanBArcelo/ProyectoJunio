<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/api/users")
 */
class UserApiController extends AbstractController
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="api_user_list", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(User::class);
        $users = $repository->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="api_user_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/", name="api_user_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validar datos
        $constraint = new Assert\Collection([
            'nombre' => new Assert\NotBlank(),
            'nick' => new Assert\NotBlank(),
            'email' => new Assert\Email(),
        ]);
        $violations = $this->validator->validate($data, $constraint);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->setNombre($data['nombre'])
            ->setNick($data['nick'])
            ->setEmail($data['email'])
            ->setPassword('123456'); // O cualquier lógica para generar/establecer la contraseña

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Usuario creado con éxito', 'user' => $user->toArray()], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_user_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Usuario eliminado con éxito'], Response::HTTP_NO_CONTENT);
    }
}
