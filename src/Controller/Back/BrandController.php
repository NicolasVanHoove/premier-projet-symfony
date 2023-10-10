<?php

namespace App\Controller\Back;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
 * @Route("/back")
 */
class BrandController extends AbstractController
{
    /**
     * @Route("/brand/browse", name="back_brand_browse")
     */
    public function index(BrandRepository $brandRepository): Response
    {
        $brands = $brandRepository->findAll();

        return $this->render('back/brand/brand_browse.html.twig', [
            'brands' => $brands,
        ]);
    }

    /**
     * @Route("/brand/show/{id<\d+>}", name="back_brand_show")
     */
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $brand = $entityManager->getRepository(Brand::class)->find($id);

        return $this->render('back/brand/brand_show.html.twig', [
            'brand' => $brand,
        ]);
    }

    /**
     * Page et form d'ajout d'une brand
     *
     * @Route("/brand/add", name="back_brand_add", methods={"GET", "POST"})
     */
    public function addBrand(Request $request, EntityManagerInterface $entityManager)
    {

        $brand = new Brand();

        // créer le formulaire
        $form = $this->createForm(BrandType::class, $brand);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();

            // ajouter un flash message
            $this->addFlash('success', 'Marque ajoutée');

            return $this->redirectToRoute('back_brand_browse');
        }

        // afficher le formulaire
        return $this->renderForm('back/brand/brand_add.html.twig', [
            'brandForm' => $form,
            'brand' => $brand,
        ]);
    }

    /**
     * Page de modification d'une marque
     *
     * @Route("/brand/{id<\d+>}/edit", name="back_brand_edit", methods={"GET", "POST"})
     */
    public function editBrand(Request $request, EntityManagerInterface $entityManager, Brand $brand)
    {

        $form = $this->createForm(BrandType::class, $brand);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($brand);
            $entityManager->flush();

            // ajouter un flash message
            $this->addFlash('success', 'Marque Modifiée');

            return $this->redirectToRoute('back_brand_show', ["id" => $brand->getId()]);
        }

        // afficher le formulaire
        return $this->renderForm('/back/brand/brand_edit.html.twig', [
            'brandForm' => $form,
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/brand/{id<\d+>}/delete", name="back_brand_delete", methods={"POST"})
     */
    public function delete(Request $request, Brand $brand, BrandRepository $brandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete-brand-' . $brand->getId(), $request->request->get('_token'))) {
            $brandRepository->remove($brand, true);
            $this->addFlash('success', 'Marque supprimée');
        }

        return $this->redirectToRoute('back_brand_browse', [], Response::HTTP_SEE_OTHER);
    }
}
