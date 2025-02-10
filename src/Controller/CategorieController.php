<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;

final class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'categorie.index')]
    public function index(Request $request, CategorieRepository $repository, EntityManagerInterface $em): Response
    {
        $categorie = new Categorie();
        $categorie->setCode('P9LIII')->setDescription('Chambre falille pour 9 persons');
        $em->persist($categorie);
        $em->flush(); 
        $categories = $repository->findAll();
       
       return $this->render('categorie/index.html.twig',[
        'categories' => $categories
    ]);
    }
    #[Route('/create', name: 'categorie.create')]
    public function create(Request $request, CategorieRepository $repository, EntityManagerInterface $em): Response
    {
       $categorie = new Categorie();
       $categorie->setCode('P9LI')->setDescription('Chambre pour 9 persons');
       $em->persist($categorie);
       $em->flush(); 
       return $this->render('categorie/index.html.twig',[
       'categories' => $categories
    ]);
    }
    #[Route('/categories/{code}-{id}', name: 'categorie.show', requirements: ['id' => '\d+','code' => '[a-zA-Z0-9-]+'])]
    public function show(Request $request, string $code, int $id, CategorieRepository $repository): Response
    {
   
        $categorie = $repository->find($id);
        if ($categorie->getCode() <> $code) {
            return $this->redirectToRoute('categorie.show',[
                'code'=> $categorie->getCode(), 'id' => $categorie->getId()
            ]);
        }
        return $this->render('categorie/show.html.twig',
            [
                'categorie' => $categorie
        ]);
        
    }
}
