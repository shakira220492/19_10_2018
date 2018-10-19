<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Profile/Default/index.html.twig');
    }
    
    public function getUserSpecificInformationAction(Request $request)
    {
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            
            $followers = $em->createQuery(
                "SELECT u.userId 
                FROM HomeBundle:Follow f 
                JOIN HomeBundle:User u 
                WITH f.followInfluencer = u.userId 
                WHERE u.userId = '$userId'"
            );
            $followers_v = $followers->getResult();
                    
            $influencers = $em->createQuery(                    
                "SELECT u.userId 
                FROM HomeBundle:Follow f 
                JOIN HomeBundle:User u 
                WITH f.followFollower = u.userId 
                WHERE u.userId = '$userId'"
            );
            $influencers_v = $influencers->getResult();
            
            $videos = $em->createQuery(
                "SELECT v.videoId, v.videoName, v.videoDescription, v.videoImage, 
                v.videoContent, v.videoUpdatedate, v.videoAmountViews, 
                v.videoAmountComments, v.videoLikes, v.videoDislikes 
                FROM HomeBundle:Video v 
                JOIN HomeBundle:User u 
                WITH v.user = u.userId 
                WHERE u.userId = '$userId'"
            );
            $videos_v = $videos->getResult();
            
            $specific_list = $em->createQuery(
                "SELECT sl.specificlistId, sl.specificlistName 
                FROM HomeBundle:Specificlist sl 
                JOIN HomeBundle:User u 
                WITH sl.user = u.userId 
                WHERE u.userId = '$userId'"
            );
            $specific_list_v = $specific_list->getResult();
            
            // notifications new video - this in other bundle
            $datamining = $em->createQuery(
            );
            
            // this in other bundle
            $history = $em->createQuery(
            );
            
            $user = $em->createQuery(
                "SELECT u.userId, u.userName, u.userFirstgivenname, u.userSecondgivenname, 
                u.userFirstfamilyname, u.userSecondfamilyname, u.userEmail, u.userPassword, u.userBiography 
                FROM HomeBundle:User u 
                WHERE u.userId = '$userId'"
            );
            
            $user_v = $user->getResult();
            
            /////////////////////////////////////////////////////////////////////////////
            
            $amountFollowers = 0;
            while (isset($followers_v[$amountFollowers]['userId'])) {
                $amountFollowers++; // 
            }
                                    
            $amountInfluencers = 0;
            while (isset($influencers_v[$amountInfluencers]['userId'])) {
                $amountInfluencers++; // 
            }
                                    
            $amountVideos = 0;
            while (isset($videos_v[$amountVideos]['videoId'])) {
                $amountVideos++; // this is a link to show the videos that belong to the user
            }
                                                
            $amountSpecificLists = 0;
            while (isset($specific_list_v[$amountSpecificLists]['specificlistId'])) {
                $amountSpecificLists++; // this is another function, and another div 
            }
            
            /////////////////////////////////////////////////////////////////////////////
            
            if ($user_v) {
                $userId_Value = $user_v[0]['userId'];
                $userName_Value = $user_v[0]['userName'];
                $userFirstgivenname_Value = $user_v[0]['userFirstgivenname'];
                $userSecondgivenname_Value = $user_v[0]['userSecondgivenname'];
                $userFirstfamilyname_Value = $user_v[0]['userFirstfamilyname'];
                $userSecondfamilyname_Value = $user_v[0]['userSecondfamilyname'];
                $userEmail_Value = $user_v[0]['userEmail'];
                $userPassword_Value = $user_v[0]['userPassword'];
                $userBiography_Value = $user_v[0]['userBiography'];
                
                $amountFollowers_Value = $amountFollowers;
                $amountInfluencers_Value = $amountInfluencers;
                $amountVideos_Value = $amountVideos;
                $amountSpecificLists_Value = $amountSpecificLists;
                
            } else {
                $userId_Value = "_";
                $userName_Value = "_";
                $userFirstgivenname_Value = "_";
                $userSecondgivenname_Value = "_";
                $userFirstfamilyname_Value = "_";
                $userSecondfamilyname_Value = "_";
                $userEmail_Value = "_";
                $userPassword_Value = "_";
                $userBiography_Value = "_";
                
                $amountFollowers_Value = "_";
                $amountInfluencers_Value = "_";
                $amountVideos_Value = "_";
                $amountSpecificLists_Value = "_";
            }
            
            $videoFromUser[0] = array(
                'userId' => $userId_Value,
                'userName' => $userName_Value,
                'userFirstgivenname' => $userFirstgivenname_Value,
                'userSecondgivenname' => $userSecondgivenname_Value,
                'userFirstfamilyname' => $userFirstfamilyname_Value,
                'userSecondfamilyname' => $userSecondfamilyname_Value,
                'userEmail' => $userEmail_Value,
                'userPassword' => $userPassword_Value,
                'userBiography' => $userBiography_Value,
                
                'amountFollowers' => $amountFollowers_Value,
                'amountInfluencers' => $amountInfluencers_Value,
                'amountVideos' => $amountVideos_Value,
                'amountSpecificLists' => $amountSpecificLists_Value
            );
            
            return new Response(json_encode($videoFromUser), 200, array('Content-Type' => 'application/json'));
        }
    }
}