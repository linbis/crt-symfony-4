<?php

namespace App\Controller;

use JetBrains\PhpStorm\ArrayShape;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController
{
    /**
     * @return string[]
     */
    #[Route('/', 'home')]
    #[Template('view/home/index.html.twig')]
    #[ArrayShape(['title' => "string"])]
    public function index(): array
    {
        return [
            'title' => 'Главная страница'
        ];
    }
}