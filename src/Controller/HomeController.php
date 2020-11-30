<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/page/{page}", name="home_paginated")
     */
    public function index(GameRepository $gameRepository, PaginatorInterface $paginator, $page = 1): Response
    {
    	$games = $gameRepository->getLatestPaginatedGames($paginator, $page);
    	$games->setUsedRoute('home_paginated');
        return $this->render('home/index.html.twig', [
            'games' => $games, //entre gillements c'est le nom de la variable dans le template twig
        ]);
    }


}