<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class FOSSecurityController extends FOSRestController{

    /**
     * @Rest\Post("/api/signup")
     * @Rest\View(StatusCode=201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function signup(User $user, RoleRepository $role, UserPasswordEncoderInterface $encoder){
        // dd($user);
        // $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        // $userSign = $serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array('signup')));
        // dd($userSign);
        $roleUser = $role->findOneBy(['code' => 'ROLE_USER']);
        $em = $this->getDoctrine()->getManager();
        $user->setCreatedAt(new \DateTime);
        // dd($user->getPassword());
        $hash = $encoder->encodePassword($user,$user->getPassword());
        $user->setPassword($hash);
        $user->setRole($roleUser);
        $em->persist($user);
        $em->flush();
        return new Response('Inscription effectuée');
    }
}