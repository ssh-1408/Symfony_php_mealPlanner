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

        $offset = (int) $request->query->get('week', 0); // 0 = current week, -1 = last, +1 = next
        $now = new \DateTimeImmutable();
        $startOfWeek = $now->modify('monday this week')->modify("+$offset week");

        $currentDay = $now->format('l'); // "Monday", "Tuesday", etc.
        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->add(new \DateInterval("P{$i}D")); // FIXED here
            $weekDays[] = [
                'label' => $day->format('l'),     // e.g. "Monday"
                'date' => $day->format('Y-m-d'),  // e.g. "2025-04-28"
                'display' => $day->format('D – j M'), // "Mon – 28 Apr"
            ];
        }
        $mealPlans = $mealPlanRepository->findAll();

        $plansByDayAndMeal = [];
        foreach ($mealPlans as $plan) {
            $day = $plan->getMealDate()->format('l');         // e.g., Monday
            $meal = $plan->getMealtime()->value;              // e.g., lunch

            $plansByDayAndMeal[$day][$meal] = [
                'id' => $plan->getId(),
                'recipe' => [
                    'title' => $plan->getRecipe()->getTitle()
                ]
            ];
        }

        return $this->render('meal_plan/index.html.twig', [
            'weekDays' => $weekDays,
            'currentDay' => $currentDay,
            'now' => $now,
            'offset' => $offset,
            'meal_plans' => $mealPlans,
            'plans' => $plansByDayAndMeal,
        ]);
    }

    #[Route('/new', name: 'app_meal_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mealPlan = new MealPlan();
        // Get date and mealtime from query
        $mealDate = $request->query->get('date');
        $mealtime = $request->query->get('mealtime');

        if ($mealDate) {
            $mealPlan->setMealDate(new \DateTimeImmutable($mealDate));
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
