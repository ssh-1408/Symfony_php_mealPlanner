<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function index(): Response
    {

        $team = [
            [
                'name' => 'Alfred Mealer',
                'role' => 'CEO',
                'strength' => 'Likes to stay healthy',
                'image' => 'alfred2.jpg',
            ],
            [
                'name' => 'Miriam Zhang',
                'role' => 'Health Coach',
                'strength' => 'Passionate about healthy living',
                'image' => 'miriam2.jpg',
            ],
            [
                'name' => 'Jan Köhler',
                'role' => 'Controller',
                'strength' => 'Strong attention to detail',
                'image' => 'jan3.jpg',
            ],
            [
                'name' => 'Lena Bauer',
                'role' => 'Assistentin',
                'strength' => 'Organized and reliable',
                'image' => 'lena2.jpg',
            ]
        ];


        return $this->render('team/team.html.twig', [
            'team' => $team,
        ]);
    }
}
