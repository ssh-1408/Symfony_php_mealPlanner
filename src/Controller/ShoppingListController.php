<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use App\Form\ShoppingListTypeForm;
use App\Repository\ShoppingListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ShoppingListController extends AbstractController
{
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
                $item->setShoppingList($shoppingList); // <-- THIS IS CRUCIAL
            }

            $em->persist($shoppingList);
            $em->flush();

            return $this->redirectToRoute('app_shopping_list_index');
        }

        return $this->render('shopping_list/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/index', name: 'app_shopping_list_index')]
    public function index(ShoppingListRepository $repo): Response
    {
        // Nur Listen des aktuellen Users anzeigen
        $lists = $repo->findBy(['user' => $this->getUser()]);
        return $this->render('shopping_list/index.html.twig', [
            'lists' => $lists,
        ]);
    }
}
