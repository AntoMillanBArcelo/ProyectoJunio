<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/users")
 */
class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
            $data[] = $this->serializeUser($user);
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

        $data = $this->serializeUser($user);

        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/", name="api_user_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        
        $user = new User();
        $user->setEmail($data['email']);
    
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Usuario creado con éxito', 'user' => $user->toArray()], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_user_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Usuario eliminado con éxito'], Response::HTTP_NO_CONTENT);
    }

    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'url' => $user->getURL(),
            'rol' => $user->getRol()
        ];
    }
}
