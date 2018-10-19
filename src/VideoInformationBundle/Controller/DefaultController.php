<?php

namespace VideoInformationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {        
        return $this->render('@VideoInformation/Default/index.html.twig');
    }
    
    public function getInfoAboutVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $video = $em->createQuery(
                    "SELECT v.videoId, v.videoName, v.videoDescription, v.videoImage, v.videoContent, v.videoUpdatedate, v.videoAmountViews, v.videoLikes, v.videoDislikes, 
                        u.userId, u.userName, u.userEmail, u.userPassword 
                    FROM HomeBundle:Video v 
                    JOIN HomeBundle:User u 
                    WITH u.userId = v.user 
                    WHERE v.videoId = '1'");

            $videos = $video->getResult();


            
            if ($videos) {
                
                $videoUpdatedate = $videos[0]['videoUpdatedate'];
                
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');
                
                $videoId_Value = $videos[0]['videoId'];
                $videoName_Value = $videos[0]['videoName'];
                $videoDescription_Value = $videos[0]['videoDescription'];
                $videoImage_Value = $videos[0]['videoImage'];
                $videoContent_Value = $videos[0]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videos[0]['videoAmountViews'];
                $videoLikes_Value = $videos[0]['videoLikes'];
                $videoDislikes_Value = $videos[0]['videoDislikes'];
                $userId_Value = $videos[0]['userId'];
                $userName_Value = $videos[0]['userName'];
                $userEmail_Value = $videos[0]['userEmail'];
                $userPassword_Value = $videos[0]['userPassword'];
            } else {
                $videoId_Value = "_";
                $videoName_Value = "_";
                $videoDescription_Value = "_";
                $videoImage_Value = "_";
                $videoContent_Value = "_";
                $videoUpdatedate_Value = "_";
                $videoAmountViews_Value = "_";
                $videoLikes_Value = "_";
                $videoDislikes_Value = "_";
                $userId_Value = "_";
                $userName_Value = "_";
                $userEmail_Value = "_";
                $userPassword_Value = "_";
            }

            $users2 = array();
            $users2[0] = array(
                'videoId' => $videoId_Value,
                'videoName' => $videoName_Value,
                'videoDescription' => $videoDescription_Value,
                'videoImage' => $videoImage_Value,
                'videoContent' => $videoContent_Value,
                'videoUpdatedate' => $videoUpdatedate_Value,
                'videoAmountViews' => $videoAmountViews_Value,
                'videoLikes' => $videoLikes_Value,
                'videoDislikes' => $videoDislikes_Value,
                'userId' => $userId_Value,
                'userName' => $userName_Value,
                'userEmail' => $userEmail_Value,
                'userPassword' => $userPassword_Value
            );

            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

}
