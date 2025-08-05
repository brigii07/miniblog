<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostController extends AbstractController
{
    private PostRepository $postRepository;
    private NormalizerInterface $normalizer;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        PostRepository $postRepository, 
        NormalizerInterface $normalizer,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->postRepository = $postRepository;
        $this->normalizer = $normalizer;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    #[Route("/api/posts", methods: ["GET"])]
    public function getPosts(): JsonResponse
    {
        $posts = $this->postRepository->findAll();

        $postsAsArray = $this->normalizer->normalize($posts, null, [
            'groups' => ['post:read'],
            //'datetime_format' => 'Y-m-d H:i:s', 
            
            'datetime_format' => 'c',
        ]);

        return new JsonResponse($postsAsArray);
    }

    #[Route("/api/posts", methods: ["POST"])]
    public function createPost(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        $post = new Post();
        $post->setTitle($data['title'] ?? '');
        $post->setContent($data['content'] ?? '');
        $post->setAuthor($data['author'] ?? '');
        $post->setCreatedAt(new \DateTime());
        $post->setUpdatedAt(new \DateTime());

        // Validation
        $errors = $this->validator->validate($post);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $postAsArray = $this->normalizer->normalize($post, null, [
            'groups' => ['post:read'],
            'datetime_format' => 'Y-m-d H:i:s',
        ]);

        return new JsonResponse($postAsArray, 201);
    }

    #[Route("/api/posts/{id}", methods: ["GET"])]
    public function getPost(int $id): JsonResponse
    {
        $post = $this->postRepository->find($id);
        
        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        $postAsArray = $this->normalizer->normalize($post, null, [
            'groups' => ['post:read'],
            'datetime_format' => 'Y-m-d H:i:s',
        ]);

        return new JsonResponse($postAsArray);
    }

    #[Route("/api/posts/{id}", methods: ["PUT"])]
    public function updatePost(int $id, Request $request): JsonResponse
    {
        $post = $this->postRepository->find($id);
        
        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        
        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        // Update fields
        if (isset($data['title'])) {
            $post->setTitle($data['title']);
        }
        if (isset($data['content'])) {
            $post->setContent($data['content']);
        }
        if (isset($data['author'])) {
            $post->setAuthor($data['author']);
        }
        
        $post->setUpdatedAt(new \DateTime());

        // Validation
        $errors = $this->validator->validate($post);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        $this->entityManager->flush();

        $postAsArray = $this->normalizer->normalize($post, null, [
            'groups' => ['post:read'],
            'datetime_format' => 'Y-m-d H:i:s',
        ]);

        return new JsonResponse($postAsArray);
    }

    #[Route("/api/posts/{id}", methods: ["DELETE"])]
    public function deletePost(int $id): JsonResponse
    {
        $post = $this->postRepository->find($id);
        
        if (!$post) {
            return new JsonResponse(['error' => 'Post not found'], 404);
        }

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return new JsonResponse(null, 204);
    }
}