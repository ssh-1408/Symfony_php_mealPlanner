<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recipes')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'recipe_index', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepo): Response
    {
        $recipes = $recipeRepo->findBy(['isApproved' => true]);
        return $this->json($recipes);
    }

    #[Route('/', name: 'recipe_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $recipe = new Recipe();
        $recipe->setTitle($data['title'] ?? '');
        $recipe->setDescription($data['description'] ?? '');
        $recipe->setIngredients($data['ingredients'] ?? '');
        $recipe->setCalories($data['calories'] ?? 0);
        $recipe->setPreparationTimeMinutes($data['preparation_time_minutes'] ?? 0);
        $recipe->setIsVegetarian($data['is_vegetarian'] ?? false);
        $recipe->setIsVegan($data['is_vegan'] ?? false);
        $recipe->setAllergens($data['allergens'] ?? '');
        $recipe->setExternalLink($data['external_link'] ?? '');
        $recipe->setCreatedAt(new \DateTimeImmutable());
        $recipe->setIsApproved(false);
        $recipe->setFkUser($this->getUser());

        $em->persist($recipe);
        $em->flush();

        return $this->json($recipe, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        return $this->json($recipe);
    }

    #[Route('/{id}', name: 'recipe_update', methods: ['PUT'])]
    public function update(Request $request, Recipe $recipe, EntityManagerInterface $em): Response
    {
        if ($recipe->getFkUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $data = json_decode($request->getContent(), true);
        $recipe->setTitle($data['title'] ?? $recipe->getTitle());
        $recipe->setDescription($data['description'] ?? $recipe->getDescription());
        $recipe->setIngredients($data['ingredients'] ?? $recipe->getIngredients());
        $recipe->setCalories($data['calories'] ?? $recipe->getCalories());
        $recipe->setPreparationTimeMinutes($data['preparation_time_minutes'] ?? $recipe->getPreparationTimeMinutes());
        $recipe->setIsVegetarian($data['is_vegetarian'] ?? $recipe->isIsVegetarian());
        $recipe->setIsVegan($data['is_vegan'] ?? $recipe->isIsVegan());
        $recipe->setAllergens($data['allergens'] ?? $recipe->getAllergens());
        $recipe->setExternalLink($data['external_link'] ?? $recipe->getExternalLink());

        $em->flush();

        return $this->json($recipe);
    }

    #[Route('/{id}', name: 'recipe_delete', methods: ['DELETE'])]
    public function delete(Recipe $recipe, EntityManagerInterface $em): Response
    {
        if ($recipe->getFkUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $em->remove($recipe);
        $em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}/approve', name: 'recipe_approve', methods: ['PATCH'])]
    public function approve(Recipe $recipe, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recipe->setIsApproved(true);
        $em->flush();

        return $this->json($recipe);
    }
}
