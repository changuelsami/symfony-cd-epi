<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;

class FrontController extends Controller
{
    /**
     * @Route("/", name="front")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Categorie::class);
        $liste = $repo->findAll();  
        return $this->render('front/index.html.twig', ['liste' => $liste]);
    }
}
