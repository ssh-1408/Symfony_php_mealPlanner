<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use App\Form\ShoppingListTypeForm;
use App\Form\ShoppingListItemTypeForm;
use App\Repository\ShoppingListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ShoppingListController extends AbstractController
{
    // Add new list
    #[Route('/new', name: 'app_shopping_list_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $shoppingList = new ShoppingList();
        $shoppingList->setUser($this->getUser());

        $form = $this->createForm(ShoppingListTypeForm::class, $shoppingList);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ensure all items are linked to the list
            foreach ($shoppingList->getItems() as $item) {
                $item->setShoppingList($shoppingList); // <-- THIS IS IMPORTANT
            }

            $em->persist($shoppingList);
            $em->flush();

            return $this->redirectToRoute('app_shopping_list_index');
        }

        return $this->render('shopping_list/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // Overview
    #[Route('/index', name: 'app_shopping_list_index')]
    public function index(ShoppingListRepository $repo): Response
    {
        // Show lists of the current user
        $lists = $repo->findBy(['user' => $this->getUser()]);
        return $this->render('shopping_list/index.html.twig', [
            'lists' => $lists,
        ]);
    }

    // Edit list
    #[Route('/{id}/edit', name: 'app_shopping_list_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        ShoppingList $shoppingList,
        EntityManagerInterface $em
    ): Response {
        // Verify current user owns this list
        if ($shoppingList->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ShoppingListTypeForm::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ensure all items are linked to this list
            foreach ($shoppingList->getItems() as $item) {
                $item->setShoppingList($shoppingList);
            }

            $em->flush();

            $this->addFlash('success', 'List updated!');
            return $this->redirectToRoute('app_shopping_list_index');
        }

        return $this->render('shopping_list/edit.html.twig', [
            'form' => $form->createView(),
            'list' => $shoppingList,
        ]);
    }

    // Delete list
    #[Route('/{id}', name: 'app_shopping_list_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        ShoppingList $shoppingList,
        EntityManagerInterface $em
    ): Response {
        // Verify ownership
        if ($shoppingList->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $shoppingList->getId(), $request->request->get('_token'))) {
            $em->remove($shoppingList);
            $em->flush();
            $this->addFlash('success', 'List deleted!');
        }

        return $this->redirectToRoute('app_shopping_list_index');
    }
}
