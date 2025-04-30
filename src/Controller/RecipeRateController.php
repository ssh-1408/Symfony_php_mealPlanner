<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\RecipeRating;
use App\Repository\RecipeRatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recipes')]
class RecipeRateController extends AbstractController
{
    #[Route('/{id}/ratings', name: 'rate_recipe', methods: ['POST'])]
    public function rateRecipe(
        Recipe $recipe,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $data = json_decode($request->getContent(), true);

        $rating = new RecipeRating();
        $rating->setStars($data['stars']);
        $rating->setCreatedAt(new \DateTimeImmutable());
        $rating->setFkUser($this->getUser());
        $rating->setFkRecipe($recipe);

        $em->persist($rating);
        $em->flush();

        return $this->json($rating, Response::HTTP_CREATED);
    }

    #[Route('/{id}/ratings/average', name: 'average_rating', methods: ['GET'])]
    public function averageRating(Recipe $recipe, RecipeRatingRepository $repo): Response
    {
        $ratings = $repo->findBy(['fkRecipe' => $recipe]);
        if (count($ratings) === 0) {
            return $this->json(['average' => null]);
        }

        $sum = array_reduce($ratings, fn ($acc, $r) => $acc + $r->getStars(), 0);
        $average = $sum / count($ratings);

        return $this->json(['average' => round($average, 2)]);
    }

    #[Route('/ratings/{id}', name: 'update_rating', methods: ['PUT'])]
    public function updateRating(RecipeRating $rating, Request $request, EntityManagerInterface $em): Response
    {
        if ($rating->getFkUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $data = json_decode($request->getContent(), true);
        $rating->setStars($data['stars']);
        $em->flush();

        return $this->json($rating);
    }

    #[Route('/ratings/{id}', name: 'delete_rating', methods: ['DELETE'])]
    public function deleteRating(RecipeRating $rating, EntityManagerInterface $em): Response
    {
        if ($rating->getFkUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $em->remove($rating);
        $em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
