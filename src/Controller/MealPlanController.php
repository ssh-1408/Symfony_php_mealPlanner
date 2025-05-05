<?php

namespace App\Controller;

use App\Entity\Bmi;
use App\Entity\MealPlan;
use App\Enum\Mealtime;
use App\Form\BmiForm;
use App\Entity\User;
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
    #[Route(name: 'app_meal_plan_index', methods: ['GET', 'POST'])]
    public function index(Request $request, MealPlanRepository $mealPlanRepository, EntityManagerInterface $entityManager): Response
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

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $mealPlansForDay = $mealPlanRepository->findByDateAndUser($currentDate, $user);

        // BMI form
        $bmi = $user->getBmi() ?? new Bmi();
        $recommendedCalories = $bmi ? $bmi->estimateCalories() : null;
        $form = $this->createForm(BmiForm::class, $bmi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $height = $bmi->getHeight() / 100;
            $calculatedBmi = $bmi->getMass() / ($height ** 2);
            $bmi->setBmiValue(round($calculatedBmi, 2));
            $bmi->setCalculatedAt(new \DateTimeImmutable());
            $bmi->setUser($user); // Important for new records
            $user->setBmi($bmi);  // Sets the relation both ways

            $entityManager->persist($bmi);
            $entityManager->flush();

            // Store ID in session and redirect
            $request->getSession()->set('bmi_id', $bmi->getId());

            return $this->redirectToRoute('app_meal_plan_index');
        }
        // Try to load the latest BMI if available
        $bmi = null;
        if ($bmiId = $request->getSession()->get('bmi_id')) {
            $bmi = $entityManager->getRepository(Bmi::class)->find($bmiId);
            // Clear it after displaying once
            $request->getSession()->remove('bmi_id');
        }


        return $this->render('meal_plan/index.html.twig', [
            'weekDays' => $weekDays,
            'currentDate' => $currentDate->format('Y-m-d'),
            'now' => $now,
            'offset' => $offset,
            'meal_plans' => $mealPlansForDay,
            'form' => $form->createView(),
            'bmi' => $bmi,
            'recommendedCalories' => $recommendedCalories,
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
        $recipe = $mealPlan->getRecipe();

        return $this->render('meal_plan/show.html.twig', [
            'mealPlan' => $mealPlan,
            'recipe' => $recipe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meal_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MealPlan $mealPlan, EntityManagerInterface $entityManager): Response
    {
        if ($mealPlan->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Access denied.');
        }

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
        if ($mealPlan->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Access denied.');
        }

        if ($this->isCsrfTokenValid('delete' . $mealPlan->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mealPlan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meal_plan_index', [], Response::HTTP_SEE_OTHER);
    }
}
