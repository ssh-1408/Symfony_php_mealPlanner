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
                'image' => 'alfred.jpg',
            ],
            [
                'name' => 'Lena Bauer',
                'role' => 'Assistentin',
                'strength' => 'Organized and reliable',
                'image' => 'lena.jpg',
            ],
            [
                'name' => 'Jan Köhler',
                'role' => 'Controller',
                'strength' => 'Strong attention to detail',
                'image' => 'jan.jpg',
            ],
            [
                'name' => 'Miriam Zhang',
                'role' => 'Entwicklerin',
                'strength' => 'Problem solver and fast coder',
                'image' => 'miriam.jpg',
            ],
            [
                'name' => 'Tom Schneider',
                'role' => 'Ernährungsberater',
                'strength' => 'Passionate about healthy living',
                'image' => 'tom.jpg',
            ],
        ];


        return $this->render('team/team.html.twig', [
            'team' => $team,
        ]);
    }
}
