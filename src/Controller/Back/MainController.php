<?php

namespace App\Controller\Back;

use App\Repository\CarRepository;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/back/main", name="app_back_main")
     */
    public function index(CarRepository $carRepository, BrandRepository $brandRepository): Response
    {
        $cars = $carRepository->findOrderedById(5);

        $brands = $brandRepository->findOrderedById(5);

        return $this->render('back/main/index.html.twig', [
            'cars' => $cars,
            'brands' => $brands
        ]);
    }
}
