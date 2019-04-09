<?php

namespace App\Controller;

use App\Repository\WikiRepository;
use App\Entity\Wiki;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;


class FOSWikiController extends FOSRestController{
    /**
     * @GET(
     *  path="/api/wiki",
     * name="show_all_wiki",
     * )
     * @View
     */
    public function showAll(WikiRepository $wikiRepository){
        
        $wikis = $wikiRepository->findAllCustom();
        // dump($wikis);exit;
        return $wikis;
        
    }

    
}