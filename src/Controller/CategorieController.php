<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'categorie.index')]
    public function index(request $request): Response
    {
       return $this->render('categorie/index.html.twig');
    }
    #[Route('/categorie/{slug}-{id}', name: 'categorie.show', requirements: ['id' => '\d+','slug' => '[a-z0-9-]+'])]
    public function show(request $request, string $slug, int $id): Response
    {
        return $this->render('categorie/show.html.twig',
            [
            'slug' => $slug,
            'id' => $id
        ]);
        
    }
}
