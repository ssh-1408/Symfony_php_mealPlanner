<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recipe;
use App\Form\UserEditTypeForm;
use App\Form\RecipeTypeForm;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAccessController extends AbstractController
{
    // --- USER SECTION ---

    #[Route('/admin/users', name: 'admin_users_index')]
    public function indexUsers(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/users/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/admin/users/{id}/edit', name: 'admin_users_edit')]
    public function editUser(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UserEditTypeForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'User updated successfully.');
            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('admin/users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/users/{id}/delete', name: 'admin_users_delete')]
    public function deleteUser(User $user, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'User deleted.');
        return $this->redirectToRoute('admin_users_index');
    }

    // --- RECIPE SECTION ---

    #[Route('/admin/recipes', name: 'admin_recipes_index')]
    public function indexRecipes(RecipeRepository $recipeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recipes = $recipeRepository->findBy(['approvedByAdmin' => false]);

        return $this->render('admin/recipes/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/admin/recipes/{id}/show', name: 'admin_recipes_show')]
    public function showRecipe(Recipe $recipe): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/recipes/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/admin/recipes/{id}/edit', name: 'admin_recipes_edit')]
    public function editRecipe(Recipe $recipe, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(RecipeTypeForm::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Recipe updated successfully.');
            return $this->redirectToRoute('admin_recipes_index');
        }

        return $this->render('admin/recipes/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/recipes/{id}/approve', name: 'admin_recipes_approve')]
    public function approveRecipe(Recipe $recipe, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recipe->setApprovedByAdmin(true);
        $em->flush();

        $this->addFlash('success', 'Recipe approved successfully.');
        return $this->redirectToRoute('admin_recipes_index');
    }
}
