<?php

namespace App\Controller\Front;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
 * @Route("/front")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/car/browse", name="front_car_browse")
     */
    public function browse(CarRepository $carRepository, BrandRepository $brandRepository): Response
    {
        $cars = $carRepository->findAll();

        $brands = $brandRepository->findAll();

        return $this->render('front/car/car_browse.html.twig', [
            'cars' => $cars,
            'brands' => $brands
        ]);
    }

    /**
     * @Route("/car/show/{id<\d+>}", name="front_car_show")
     */
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $car = $entityManager->getRepository(Car::class)->find($id);

        return $this->render('front/car/car_show.html.twig', [
            'car' => $car,
        ]);
    }
}
