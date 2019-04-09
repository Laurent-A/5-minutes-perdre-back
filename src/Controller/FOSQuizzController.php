<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Quizz;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Repository\QuizzRepository;
use App\Repository\AnswerRepository;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class FOSQuizzController extends FOSRestController{
    /**
     * @GET(
     * path="/api/quizz",
     * name="show_quizz",
     * )
     * @View
     * @ParamConverter("user", converter="fos_rest.request_body")
     */

    public function showQuizz(User $user = null, QuizzRepository $quizzRepository,UserRepository $userRepo){
        
	if($user != null){
            $registeredUser = $userRepo->findOneBy([
                'id' => $user->getId()
                ]);
                
                // dd($registeredUser);
            if ($registeredUser->getFavoriteTag() != null) {
                
                $currentId = $registeredUser->getId();
                $quizz = $quizzRepository->findQuizByTags($currentId);
                return $quizz;
            }
        }else{
    
        $quizz = $quizzRepository->findBy(['online'=> true]);
        $quizzToSend = $quizz[array_rand($quizz)];
          
        return $quizzToSend;
        }
    }
}

