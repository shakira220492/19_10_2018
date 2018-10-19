<?php

namespace UploadVideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UploadVideoBundle/Default/index.html.twig');
    }
    
    public function uploadVideoAction(Request $request)
    {
        $carpeta = "files/";
        opendir($carpeta);

        $video_status = "";
        $image_status = "";
        
        $filenameVideo = $_FILES['video_content']['tmp_name'];
        $destinationVideo = $carpeta . $_FILES['video_content']['name'];
        $typeVideo = $_FILES['video_content']['type'];
        if (!$typeVideo == "video/mp4") {
            move_uploaded_file($filenameVideo, $destinationVideo);
        }

        $filenameImage = $_FILES['video_portrait']['tmp_name'];
        $destinationImage = $carpeta . $_FILES['video_portrait']['name'];
        $typeImage = $_FILES['video_portrait']['type'];
        if ($typeImage == "image/jpeg" OR $typeImage == "image/jpg" OR $typeImage == "image/png") {
            move_uploaded_file($filenameImage, $destinationImage);
        }
        
        $response = array();
        $response[0] = array(
            'video_status' => $video_status,
            'image_status' => $image_status
        );
        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
        
    public function updateVideoAction(Request $request)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        
        $todayDate = date("Y-m-d");
        $videoUpdatedate = date_create_from_format('Y-m-d', $todayDate);
        
        $video_name = $_POST['video_name'];
        $video_description = $_POST['video_description'];
        $video_content = $_FILES['video_content']['name'];
        $video_portrait = $_FILES['video_portrait']['name'];
        
        $em = $this->getDoctrine()->getManager();
        
        $user = $em->createQuery(
            "SELECT u.userId 
            FROM HomeBundle:User u 
            WHERE u.userId = '$userId'"
        );

        $userInstance = $user->getResult();
        
        $userId_Value = $userInstance[0]['userId'];
        
        if ($request->isXMLHttpRequest()) {
            
            $user_value = $em->getRepository('HomeBundle:User')->findOneByUserId($userId_Value);

            $video = new \HomeBundle\Entity\Video;
            $video->setUser($user_value);
            $video->setVideoAmountComments(0);
            $video->setVideoAmountViews(0);
            $video->setVideoContent($video_content);
            $video->setVideoDescription($video_description);
            $video->setVideoDislikes(0);
            $video->setVideoImage($video_portrait);
            $video->setVideoLikes(0);
            $video->setVideoName($video_name);
            $video->setVideoUpdatedate($videoUpdatedate);
            
            $em->persist($video);
            $em->flush();

            $response = array();
            $response[] = array(
                'user' => $video->getUser(),
                'videoId' => $video->getVideoId(),
                'videoAmountComments' => $video->getVideoAmountComments(),
                'videoAmountViews' => $video->getVideoAmountViews(),
                'videoContent' => $video->getVideoContent(),
                'videoDescription' => $video->getVideoDescription(),
                'videoDislikes' => $video->getVideoDislikes(),
                'videoImage' => $video->getVideoImage(),
                'videoLikes' => $video->getVideoLikes(),
                'videoName' => $video->getVideoName(),
                'videoUpdatedate' => $video->getVideoUpdatedate()
            );
            return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function uploadKeywordAction(Request $request)
    {
        $currentKeywordContent = $_POST['currentKeywordContent'];
        $videoId = $_POST['videoId'];

        $em = $this->getDoctrine()->getManager();

        $currentKeyword = $em->createQuery(
            "SELECT k.keywordContent 
            FROM HomeBundle:Keyword k 
            WHERE k.keywordContent = '$currentKeywordContent'"
        );
        
        $currentKeywordInstance = $currentKeyword->getResult();
        
        if (isset($currentKeywordInstance[0]['keywordContent'])) {
            
            // no me ingrese la palabra
            $keyword = new \HomeBundle\Entity\Keyword;
            $keyword_value = $em->getRepository('HomeBundle:Keyword')->findOneByKeywordContent($currentKeywordContent);
            $video_value = $em->getRepository('HomeBundle:Video')->findOneByVideoId($videoId);

            $keywordVideo = new \HomeBundle\Entity\Keywordvideo;
            $keywordVideo->setKeyword($keyword_value);
            $keywordVideo->setVideo($video_value);
            $em->persist($keywordVideo);
            $em->flush();
            
            
            
            
            if ($request->isXMLHttpRequest()) {

                $response = array();
                $response[] = array(
                    'variable' => "_"
                );
                return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
            }
            
        } else
        {
            if ($request->isXMLHttpRequest()) {

                $keyword = new \HomeBundle\Entity\Keyword;
                $keyword->setKeywordContent($currentKeywordContent);
                $em->persist($keyword);
                $em->flush();

                $keywordId = $keyword->getKeywordId();
                $keyword_value = $em->getRepository('HomeBundle:Keyword')->findOneByKeywordId($keywordId);
                $video_value = $em->getRepository('HomeBundle:Video')->findOneByVideoId($videoId);

                $keywordVideo = new \HomeBundle\Entity\Keywordvideo;
                $keywordVideo->setKeyword($keyword_value);
                $keywordVideo->setVideo($video_value);
                $em->persist($keywordVideo);
                $em->flush();

                $response = array();
                $response[] = array(
                    'variable' => "_"
                );
                return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
            }
        }
    }
}