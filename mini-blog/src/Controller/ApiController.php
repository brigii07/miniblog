<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    public function posts(Request $request): JsonResponse
    {
        if ($request->getMethod() === 'GET') {
            // Simple database query without entity
            try {
                $pdo = new \PDO('sqlite:' . $this->getParameter('kernel.project_dir') . '/var/data.db');
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                $stmt = $pdo->query("SELECT * FROM post ORDER BY created_at DESC");
                $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                
                return new JsonResponse($posts);
                
            } catch (\Exception $e) {
                return new JsonResponse(['error' => $e->getMessage()], 500);
            }
        }
        
        if ($request->getMethod() === 'POST') {
            $data = json_decode($request->getContent(), true);
            
            try {
                $pdo = new \PDO('sqlite:' . $this->getParameter('kernel.project_dir') . '/var/data.db');
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                $stmt = $pdo->prepare("INSERT INTO post (title, content, author, created_at, updated_at) VALUES (?, ?, ?, datetime('now'), datetime('now'))");
                $stmt->execute([$data['title'], $data['content'], $data['author']]);
                
                $id = $pdo->lastInsertId();
                $stmt = $pdo->prepare("SELECT * FROM post WHERE id = ?");
                $stmt->execute([$id]);
                $post = $stmt->fetch(\PDO::FETCH_ASSOC);
                
                return new JsonResponse($post, 201);
                
            } catch (\Exception $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            }
        }
        
        return new JsonResponse(['error' => 'Method not allowed'], 405);
    }

    public function post(Request $request, int $id): JsonResponse
    {
        try {
            $pdo = new \PDO('sqlite:' . $this->getParameter('kernel.project_dir') . '/var/data.db');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            if ($request->getMethod() === 'DELETE') {
                $stmt = $pdo->prepare("DELETE FROM post WHERE id = ?");
                $stmt->execute([$id]);
                return new JsonResponse(null, 204);
            }
            
            // For GET, PUT operations
            $stmt = $pdo->prepare("SELECT * FROM post WHERE id = ?");
            $stmt->execute([$id]);
            $post = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$post) {
                return new JsonResponse(['error' => 'Post not found'], 404);
            }
            
            return new JsonResponse($post);
            
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}