<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipeRepository;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Demo;


final class RecipeController extends AbstractController
{
    #[Route('/demo')]
    public function demo(Demo $demo)
    {
        dd($demo);
        $recipe = new Recipe();
        $errors = $validator->validate($recipe);
        dd((string)$errors);
    }

    #[Route('/recipes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
        $recipes = $repository->findAll();
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
    #[Route('/recipes/{id}/edit', name: 'recipe.edit', methods: ['GET','POST'])]
    public function edit(Recipe $recipe, Request $request,EntityManagerInterface $em) {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success','La recette a bien été modifiée');
            return $this->redirectToRoute('recipe.index');
        }
        return $this->render('recipe/edit.html.twig',[
            'recipe' => $recipe,
            'form' => $form
        ]);
    }
    #[Route('/recipes/create', name: 'recipe.create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setCreatedAt(new \DateTimeImmutable());
            $recipe->setUpdatedAt(new \DateTimeImmutable());
                    $em->persist($recipe);
            $em->flush();
            $this->addflash('success','La recette a bien été crée');
            return $this->redirectToRoute('recipe.index');
        }
        return $this->render('recipe/create.html.twig', [
            'form' => $form
        ]);

    }
    #[Route('/recipes/{id}/edit', name: 'recipe.delete', methods: ['DELETE'])]
    public function Delete(Recipe $recipe, EntityManagerInterface $em)
    {
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success','La recette a bien été supprimée ');
        return $this->redirectToRoute('recipe.index');
    }
    
}
