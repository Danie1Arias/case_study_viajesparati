<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendorController extends AbstractController
{
    #[Route('/vendor', name: 'app_vendor')]
    public function index(): Response
    {
        return $this->render('vendor/index.html.twig', [
            'controller_name' => 'VendorController',
        ]);
    }
}
