<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EmailService $emailService): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $message = $request->request->get('message');

            if ($name && $email && $message) {
                $emailService->sendContactMessage($email, $message);

                $this->addFlash('success', 'Your message has been sent successfully!');

                return $this->redirectToRoute('app_contact');
            } else {
                $this->addFlash('danger', 'Please fill in all fields.');
            }
        }

        return $this->render('contact/contact.html.twig');
    }
}

