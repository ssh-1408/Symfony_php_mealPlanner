<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeForm;
use App\Repository\RecipeRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe')]
final class RecipeController extends AbstractController
{
    #[Route(name: 'app_recipe_index', methods: ['GET'])]
    public function index(Request $request,  RecipeRepository $recipeRepository): Response
    {
        $filter = $request->query->get('filter');

        switch ($filter) {
            case 'vegan':
                $recipes = $recipeRepository->findBy(['isVegan' => true]);
                break;
            case 'vegetarian':
                $recipes = $recipeRepository->findBy(['isVegetarian' => true, 'isVegan' => false]);
                break;
            case 'low_calories':
                $recipes = $recipeRepository->findByCaloriesLessThan(200);
                break;
            case 'quick':
                $recipes = $recipeRepository->findByPreparationTimeLessThan(30);
                break;
            default:
                $recipes = $recipeRepository->findAll();
        }

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/new', name: 'app_recipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeForm::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $recipe->setCreatedBy($this->getUser());
            $recipe->setAverageRating(0);

            $image = $form->get('image')->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $recipe->setImage($imageName);
            } else {
                $recipe->setImage('default.png');
            }

            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recipe $recipe, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(RecipeForm::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                if ($recipe->getImage() != 'default.png') {
                    unlink($this->getParameter("image_directory") . "/" . $recipe->getImage());
                }

                $imageName = $fileUploader->upload($image);
                $recipe->setImage($imageName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_delete', methods: ['POST'])]
    public function delete(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->getPayload()->getString('_token'))) {
            if ($recipe->getImage() != 'default.png') {
                unlink($this->getParameter("image_directory") . "/" . $recipe->getImage());
            }
            $entityManager->remove($recipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
