<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ComparatorController extends AbstractController
{
    /**
     * @Route("/comparator", name="comparator")
     */
    public function index()
    {
        return $this->render('comparator/index.html.twig', [
            'controller_name' => 'ComparatorController',
        ]);
    }
}
