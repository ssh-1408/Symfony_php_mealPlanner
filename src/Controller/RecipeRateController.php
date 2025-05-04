<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\RecipeRating;
use App\Form\RecipeRateForm;
use App\Repository\RecipeRatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecipeRateController extends AbstractController
{

    #[Route('/recipe/{id}/rate', name: 'app_recipe_rate')]
    public function rate(
        Request $request,
        Recipe $recipe,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to rate.');
        }

        $existingRating = $entityManager->getRepository(RecipeRating::class)->findOneBy([
            'user' => $user,
            'recipe' => $recipe,
        ]);

        $rating = $existingRating ?? new RecipeRating();
        $rating->setRecipe($recipe);
        $rating->setUser($user);
        $rating->setCreatedAt(new \DateTime());

        $form = $this->createForm(RecipeRateForm::class, $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rating);
            $entityManager->flush();

            $recipe = $rating->getRecipe();
            $average = $recipe->calculateAverageRating();
            $recipe->setAverageRating($average);

            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash('success', 'Thanks for rating!');
            return $this->redirectToRoute('app_recipe_show', ['id' => $recipe->getId()]);
        }

        return $this->render('recipe/rate.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }
}
