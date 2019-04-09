<?php

namespace App\Controller;


use App\Entity\Game;
use App\Repository\GameRepository;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class FOSGameController extends FOSRestController
{
    /**
     * @GET(
     *  path="/api/game",
     * name="show_all_game",
     * )
     * @View
     */
    public function getGame(GameRepository $gameRepo)
    {
        $games = $gameRepo->getGames();

        return $games[array_rand($games)];
    }

    /**
     * @GET(
     * path="/api/game/{id}/help",
     * name="help_game"
     * )
     * @View
     */
    public function helpGame(GameRepository $gameRepo, $id)
    {
        $currentGame = $gameRepo->findOneBy(['id'=>$id]);

        return $currentGame->getHelp();
        
    }
}
