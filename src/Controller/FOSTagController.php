<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\User;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class FOSTagController extends FOSRestController
{
     /**
     * @Rest\GET(
     *  path="/api/tags",
     * name="show_all_tags",
     * )
     * @Rest\View
     */
    public function showTags(TagRepository $tagRepo)
    {
        $tags = $tagRepo->getTagsName();

        return $tags;
    }
}
