<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipeRepository;
use App\Entity\Recipe;
use App\Form\RecipeType;


final class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response
    {
        $recipes = $repository->findAll();
        $recipes[3]->setTitle('Nem a la viande');
        $em->flush(); 
        // Ham nay luu lai thya doi trong co so du lieu 
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }
    #[Route('/recipes/rapid', name: 'recipe.rapid')]
    public function indexRapid(Request $request, RecipeRepository $repository): Response
    {
        $recipes = $repository->findWithDurationLowerThan(21);
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
    #[Route('/recipes/{id}/edit',name: 'recipe.edit')]
    public function edit(Recipe $recipe) {
        $form = $this->createForm(RecipeType::class, $recipe);
        return $this->render('recipe/edit.html.twig',[
            'recipe' => $recipe,
            'form' => $form
        ]);
    }
}
