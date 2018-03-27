<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(SessionInterface $session)
    {
        $counter = $session->get('page_counter', 0);
        $counter++;
        $session->set('page_counter', $counter);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController123',
            'counter' => $counter,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id = 'default')
    {
        if ($id == 'homepage') {
            return $this->redirectToRoute('homepage');
        }

        if ($id == 'not-found') {
            throw $this->createNotFoundException('Такого id нет');
        }

        return $this->render('default/show.html.twig', ['id' => $id]);
    }

}
