<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'main')]
class MainController extends AbstractController
{

    #[Route('/', name: '_home')]
    public function home(): Response

    {
        

        return $this->render('main/index.html.twig');
    }

    #[Route('about', name: '_about')]
    public function aboutUs(): Response
    {
        return $this->render('main/aboutUs.html.twig');
    }
}
