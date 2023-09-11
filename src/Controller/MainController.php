<?php

namespace App\Controller;

use ApiPlatform\OpenApi\Model\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        dd('sdqdqs');
    }
}
