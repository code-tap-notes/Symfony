<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipeRepository;

final class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
        $recipes = $repository->findAll();
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }
    #[Route('/recipes/{slug}-{id}', name: 'recipe.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
   
        $recipe = $repository->find($id);
        if ($recipe->getSlug() <> $slug) {
            return $this->redirectToRoute('recipe.show',[
                'slug'=> $recipe->getSlug(), 'id' => $recipe->getId()
            ]);
        }
        return $this->render('recipe/show.html.twig',
            [
                'recipe' => $recipe
        ]);
        
    }
}
