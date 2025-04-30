<?php

namespace App\Controller;

use App\Entity\MealPlan;
use App\Enum\Mealtime;
use App\Form\MealPlanForm;
use App\Repository\MealPlanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/meal/plan')]
final class MealPlanController extends AbstractController
{
    #[Route(name: 'app_meal_plan_index', methods: ['GET'])]
    public function index(Request $request, MealPlanRepository $mealPlanRepository): Response
    {
        date_default_timezone_set('Europe/Vienna');
        $now = new \DateTimeImmutable();

        $offset = (int) $request->query->get('week', 0);
        $startOfWeek = $now->modify('monday this week')->modify("+$offset week");

        $currentDateParam = $request->query->get('day');
        $currentDate = $currentDateParam
            ? new \DateTimeImmutable($currentDateParam)
            : $now;

        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->add(new \DateInterval("P{$i}D"));
            $weekDays[] = [
                'label' => $day->format('l'),        // "Monday"
                'date' => $day->format('Y-m-d'),     // "2025-05-01"
                'display' => $day->format('j F'),    // "1 May"
            ];
        }

        $mealPlansForDay = $mealPlanRepository->findByDate($currentDate);

        return $this->render('meal_plan/index.html.twig', [
            'weekDays' => $weekDays,
            'currentDate' => $currentDate->format('Y-m-d'),
            'now' => $now,
            'offset' => $offset,
            'meal_plans' => $mealPlansForDay,
        ]);
    }

    #[Route('/new', name: 'app_meal_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mealPlan = new MealPlan();
        // Get date and mealtime from query
        $date = $request->query->get('date');
        $mealtime = $request->query->get('mealtime');

        if ($date) {
            $mealPlan->setMealDate(new \DateTimeImmutable($date));
        }
        if ($mealtime) {
            $mealPlan->setMealtime(Mealtime::from(strtolower($mealtime))); // assuming you use PHP enum
        }


        $form = $this->createForm(MealPlanForm::class, $mealPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // IMPORTANT Set the currently logged in user
            $mealPlan->setUser($this->getUser());

            $entityManager->persist($mealPlan);
            $entityManager->flush();

            return $this->redirectToRoute('app_meal_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meal_plan/new.html.twig', [
            'meal_plan' => $mealPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meal_plan_show', methods: ['GET'])]
    public function show(MealPlan $mealPlan): Response
    {
        return $this->render('meal_plan/show.html.twig', [
            'meal_plan' => $mealPlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meal_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MealPlan $mealPlan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MealPlanForm::class, $mealPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_meal_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meal_plan/edit.html.twig', [
            'meal_plan' => $mealPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meal_plan_delete', methods: ['POST'])]
    public function delete(Request $request, MealPlan $mealPlan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mealPlan->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mealPlan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meal_plan_index', [], Response::HTTP_SEE_OTHER);
    }
}
