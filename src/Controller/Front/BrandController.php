<?php

namespace App\Controller\Front;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
 * @Route("/front")
 */
class BrandController extends AbstractController
{
    /**
     * @Route("/brand/browse", name="front_brand_browse")
     */
    public function browse(BrandRepository $brandRepository): Response
    {
        $brands = $brandRepository->findAll();

        return $this->render('front/brand/brand_browse.html.twig', [
            'brands' => $brands,
        ]);
    }

    /**
     * @Route("/brand/show/{id<\d+>}", name="front_brand_show")
     */
    public function show(Brand $brand): Response
    {
        // dump($brand->getCars());

        return $this->render('front/brand/brand_show.html.twig', [
            'brand' => $brand,
        ]);
    }
}
