<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostService
{
    public function __construct(
        private PostRepository $postRepository,
        private ValidatorInterface $validator
    ) {
    }

    public function getAllPosts(): array
    {
        return $this->postRepository->findBy([], ['createdAt' => 'DESC']);
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function createPost(array $data): array
    {
        $post = new Post();
        $post->setTitle($data['title'] ?? '');
        $post->setContent($data['content'] ?? '');
        $post->setAuthor($data['author'] ?? '');

        $errors = $this->validator->validate($post);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return ['success' => false, 'errors' => $errorMessages];
        }

        $this->postRepository->save($post, true);

        return ['success' => true, 'post' => $post];
    }

    public function updatePost(Post $post, array $data): array
    {
        $post->setTitle($data['title'] ?? $post->getTitle());
        $post->setContent($data['content'] ?? $post->getContent());
        $post->setAuthor($data['author'] ?? $post->getAuthor());

        $errors = $this->validator->validate($post);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return ['success' => false, 'errors' => $errorMessages];
        }

        $this->postRepository->save($post, true);

        return ['success' => true, 'post' => $post];
    }

    public function deletePost(Post $post): void
    {
        $this->postRepository->remove($post, true);
    }
}