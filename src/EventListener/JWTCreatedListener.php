<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\QuizzScoreRepository;


class JWTCreatedListener{
    /**
 * @var RequestStack
 */
private $requestStack;
    /**
 * @var quizzScoreRepo
 */
private $quizzScoreRepo;

/**
 * @param RequestStack $requestStack
 */
public function __construct(RequestStack $requestStack, QuizzScoreRepository $quizzScoreRepo)
{
    $this->requestStack = $requestStack;
    $this->quizzScoreRepo = $quizzScoreRepo;
}

/**
 * @param JWTCreatedEvent $event
 *
 * @return void
 */
public function onJWTCreated(JWTCreatedEvent $event)
{
    $request = $this->requestStack->getCurrentRequest();

    $payload       = $event->getData();
    $payload['id'] = $event->getUser()->getId();
    $payload['quizzScore'] = $this->quizzScoreRepo->findScoreByUser($event->getUser()->getId());
    // dump($payload);exit;

    $event->setData($payload);
    
    $header        = $event->getHeader();
    $header['cty'] = 'JWT';

    $event->setHeader($header);
}
}