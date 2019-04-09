<?php

namespace App\Controller\Admin;

use App\Entity\Wiki;
use App\Form\WikiType;
use App\Repository\WikiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class WikiController extends AbstractController
{
    /**
     * @Route("/admin/wiki", name="admin_wiki_index")
     */
    public function index(WikiRepository $wikiRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $wikis = $paginator->paginate($wikiRepository->findAll(),
        $request->query->getInt('page', 1),
        15);
        
        return $this->render('admin/wiki/index.html.twig', [
            'wikis' => $wikis
        ]);
    }

    /**
     * @Route("/admin/wiki/new", name="admin_wiki_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $wiki = new Wiki();
        $wiki->setCreatedAt(new \DateTime());

        $form = $this->createForm(WikiType::class, $wiki);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wiki);
            $entityManager->flush();

            return $this->redirectToRoute('admin_wiki_index');
        }

        return $this->render('admin/wiki/new.html.twig', [
            'wiki' => $wiki,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/wiki/{id}", name="wiki_show", methods={"GET"})
     */
    public function show(Wiki $wiki): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        
        $serializer = new Serializer($normalizers, $encoders);
        $data =  $serializer->serialize($wiki, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        // $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/admin/wiki/{id}/edit", name="admin_wiki_edit", methods={"GET","POST"})
     */
    public function edit(Wiki $wiki, Request $request): Response
    {
        $wiki->setUpdatedAt(new \DateTime());

        $form = $this->createForm(WikiType::class, $wiki);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_wiki_index');
        }

        return $this->render('admin/wiki/edit.html.twig', [
            'wiki' => $wiki,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/wiki/{id}/delete", name="admin_wiki_delete", methods={"DELETE"})
     */
    public function delete(Wiki $wiki, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wiki->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wiki);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_wiki_index');
    }


      /**
     * @Route("/admin/wiki/{id}/set_online_status", name="admin_wiki_online", methods={"GET", "POST"})
     */
    public function changeOnlineStatus(Wiki $wiki, EntityManagerInterface $em)
    {
        $wiki->setOnline(!$wiki->getOnline());

        $em->flush();

        return $this->redirectToRoute('admin_wiki_index');
    }
}
