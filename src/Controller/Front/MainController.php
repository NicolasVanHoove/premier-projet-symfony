<?php

namespace App\Controller\Front;

use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CarRepository $carRepository): Response
    {
        // Je récupère les données grâce au carRepository
        $cars = $carRepository->findOrderedById(1);
        // dump($cars);

        return $this->render('front/main/home.html.twig', [
            'cars' => $cars,
        ]);
    }
}
