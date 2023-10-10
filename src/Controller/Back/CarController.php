<?php

namespace App\Controller\Back;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
 * @Route("/back")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/car/browse", name="back_car_browse")
     */
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findAll();

        return $this->render('back/car/car_browse.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/car/show/{id<\d+>}", name="back_car_show")
     */
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $car = $entityManager->getRepository(Car::class)->find($id);

        return $this->render('back/car/car_show.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * Page et form d'ajout d'une car
     *
     * @Route("/car/add", name="back_car_add", methods={"GET", "POST"})
     */
    public function addCar(Request $request, EntityManagerInterface $entityManager)
    {

        $car = new Car();

        // créer le formulaire
        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // comme on a mis le champ releaseDate en non mappé, 
            // le composant form n'a pas rempli la propriété avec la valeur
            // il faut qu'on le fasse "a la mano"

            // récupère la valeur saisie dans le formulaire
            // qui est déjà un objet DateTimeImmutable
            $release_date = $form->get('release_date')->getData();
            // on finit d'hydrater notre objet
            $car->setReleaseDate($release_date);

            $entityManager->persist($car);
            $entityManager->flush();

            // ajouter un flash message
            $this->addFlash('success', 'Voiture ajoutée');

            return $this->redirectToRoute('app_back_main');
        }

        // afficher le formulaire
        return $this->renderForm('back/car/car_add.html.twig', [
            'carForm' => $form,
            'car' => $car,
        ]);
    }

    /**
     * Page de modification d'une car
     *
     * @Route("/car/{id<\d+>}/edit", name="back_car_edit", methods={"GET", "POST"})
     */
    public function editCar(Request $request, EntityManagerInterface $entityManager, Car $car)
    {
        // $car = $entityManager->getRepository(Car::class)->find($id);

        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // comme on a mis le champ releaseDate en non mappé, 
            // le composant form n'a pas rempli la propriété avec la valeur
            // il faut qu'on le fasse "a la mano"

            // récupère la valeur saisie dans le formulaire
            // qui est déjà un objet DateTimeImmutable
            $release_date = $form->get('release_date')->getData();
            // on finit d'hydrater notre objet
            $car->setReleaseDate($release_date);

            $entityManager->persist($car);
            $entityManager->flush();

            // ajouter un flash message
            $this->addFlash('success', 'Voiture Modifié');

            return $this->redirectToRoute('back_car_show', ["id" => $car->getId()]);
        }

        // afficher le formulaire
        return $this->renderForm('/back/car/car_edit.html.twig', [
            'carForm' => $form,
            'car' => $car,
        ]);
    }

    /**
     * @Route("/car/{id<\d+>}/delete", name="back_car_delete", methods={"POST"})
     */
    public function delete(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete-car-' . $car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car, true);
            $this->addFlash('success', 'Voiture supprimée');
        }

        return $this->redirectToRoute('back_car_browse', [], Response::HTTP_SEE_OTHER);
    }
}
