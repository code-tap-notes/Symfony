<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
final class CategorieController extends AbstractController
{
    #[Route('/categorie/{slug}-{id}', name: 'categorie.show')]
    public function index(request $request): Response
    {
        dd($request->attributes->get('slug'),$request->attributes->get('id'));
    }
}
