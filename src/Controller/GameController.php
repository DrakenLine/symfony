<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/game/{id<\d+>}", name="game_details")
     */
    public function gameDetails(Game $game): Response
    {
        return $this->render('game/games_by_category.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/game/add", name="game_add")
     */

    public function gameForm(Request $request, EntityManagerInterface $manager) : Response
    {
    	$game = new Game(); //recup entiré
    	$gameForm = $this->createForm(GameType::class, $game); //transmet au formulaire créé

    	$gameForm->handleRequest($request);

    	if ($gameForm->isSubmitted() && $gameForm->isValid()) {
    		//enregistrement du jeu en bdd
    		$game->setDateAdd(new \DateTime());
    		$game->setUser($this->getUser());
    		$manager->persist($game);
    		$manager->flush();
    		return $this->redirectToRoute('profile');
    	}

    	return $this->render('game/game-form.html.twig', [
    		'game_form' =>$gameForm->createView()
    	]);
    }
}
