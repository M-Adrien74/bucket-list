<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Wish;
use App\Form\WishesType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app')]
class WishController extends AbstractController
{
    #[Route('/wish', name: '_list')]
    public function list(
        Request                $request,
        EntityManagerInterface $em,
        WishRepository         $wishRepository
    ): Response
    {

        $wish = new Wish();
        $wish->setAuteur($this->getUser()->getUserIdentifier());
        $wishForm = $this->createForm(WishesType::class, $wish);
        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);
            $em->flush();
            $this->addFlash('succes', 'le wish a bien été ajouté !');
            return $this->redirectToRoute('app_detail', ['id' => $wish->getId()]);

        }
        $wishTab = $wishRepository->findAll();
        return $this->renderForm('wish/wish.html.twig',
            compact("wishTab", "wishForm"));
    }

    #[Route('/detail/{id}', name: '_detail')]
    public function detail($id,
                           WishRepository $wishRepository
    ): Response
    {

        $unWish = $wishRepository->find($id);
        dump($unWish);
        return $this->render('wish/detail.html.twig',
            compact("unWish"));
    }

    #[Route('/supprimer/{wish}', name: '_supprimer')]
    public function remove(
        Wish                   $wish,
        EntityManagerInterface $em,
    ): Response
    {
        $em->remove($wish);
        $em->flush();

        return $this->redirectToRoute('app_list');
    }

}
