<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\User;
use SocialLinks\Page;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function edit(User $user, UserRepository $repoUser, UserPasswordEncoderInterface $encoder, $id): Response
    {
        $userBDD = $repoUser->findOneBy(['id' => $id]);
        $id = $userBDD->getId();
        $role = $userBDD->getRole();
        $createdAt = $userBDD->getCreatedAt();
        // dd($createdAt);
        $em = $this->getDoctrine()->getManager();
        $userBDD->setUpdatedAt(new \DateTime);
        if($user->getPassword() == !null){
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $userBDD->setPassword($hash);
        }
        if($user->getEmail() == !null){
            $userBDD->setEmail($user->getEmail());
        }
        if($user->getUsername() == !null){
            $userBDD->setUsername($user->getUsername());
        }
        $userBDD->setId($id);
        $userBDD->setRole($role);
        
        $em->persist($userBDD);
        $em->flush();
        return new Response('Maj Ok');
    }

     /**
     * @Rest\POST("/{id}/tag/edit")
     * @Rest\View(StatusCode=201)
     * @ParamConverter("tag", converter="fos_rest.request_body")
     */

    public function editTag(User $user,Tag $tag, TagRepository $repoTag){
        
        $tagId= $tag->getId();
        $tagSearch = $repoTag->findOneBy(['id' => $tagId]);
        $toto = $user->addFavoriteTag($tagSearch);
        $em = $this->getDoctrine()->getManager();
        // $em->persist($user);
        $em->flush();
        return new Response('Ok');
    }

    /**
     * @Rest\GET("/shareFB")
     * @Rest\View(StatusCode=201)
     */
    public function shareFB()
    {
        $page = new Page([
            'url' => 'https://www.5map.fr',
            'title' => '5MAP',
            'text' => 'Si tu as 5minutes à perdre rejoins-nous',
            'image' => '#',
            'icon' => '#',
            'twitterUser' => '@Guizmoooe'
        ]);

        $fb = $page->facebook->shareUrl;

        return $fb;
    }
}
