<?php

namespace SearchengineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('@Searchengine/Default/index.html.twig');
    }

    public function searchKeywordAction(Request $request) {

        $keywords_entered_2 = $_POST["keyword"];

        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            // me retira (espacios en blanco, saltos de linea, etc) que haya al inicio de la variable $keywords_entered
            $keywords_entered_1 = ltrim($keywords_entered_2);

            // me retira (espacios en blanco, saltos de linea, etc) que haya al final de la variable $keywords_entered
            $keywords_entered = rtrim($keywords_entered_1);

            if ($keywords_entered) {
                $characters_entered_amount = 0;
                $word_entered = array();
                $temporal_word = "";

                for ($i = 0; $i < strlen($keywords_entered); $i++) {
                    //si llegase a existir un espacio entre la frase que se escribió en el buscador,
                    //entonces que me ejecute lo siguiente:
                    if ($keywords_entered[$i] == " ") {
                        $temporal_word = "";
                        $previous = $i - 1;

                        //si el caracter actual y el caracter anterior son espacios en blanco
                        if ($keywords_entered[$previous] == " ") {
                            
                        } else {
                            //si el caracter actual es espacio en blanco,
                            //pero el caracter anterior NO es espacio en blanco
                            $characters_entered_amount++; // creo que esto es pa contar la cantidad de palabras
                        }
                    } else {
                        $temporal_character = $keywords_entered[$i];
                        $temporal_word .= $temporal_character;
                        $word_entered[$characters_entered_amount] = $temporal_word;
                    }
                }

                // la consulta se hace de esta manera porque la cantidad de keywords varia
                // user

                $consulta_2 = "SELECT v.videoId, v.videoName, v.videoDescription, v.videoImage, ";
                $consulta_2 .= "v.videoContent, v.videoUpdatedate, v.videoAmountViews, ";
                $consulta_2 .= "v.videoAmountComments, v.videoLikes, v.videoDislikes, u.userId, u.userName ";
                $consulta_2 .= "FROM HomeBundle:Video v ";
                $consulta_2 .= "JOIN HomeBundle:Keywordvideo kv ";
                $consulta_2 .= "WITH v.videoId = kv.video ";
                $consulta_2 .= "JOIN HomeBundle:User u ";
                $consulta_2 .= "WITH u.userId = v.user ";
                $consulta_2 .= "JOIN HomeBundle:Keyword k ";
                $consulta_2 .= "WITH kv.keyword = k.keywordId WHERE ";
                for ($i = 0; $i <= $characters_entered_amount; $i++) {
                    $consulta_2 .= "k.keywordContent = '" . $word_entered[$i] . "' OR ";
                }
                $consulta_2 .= "k.keywordContent = ''";

                $video = $em->createQuery(
                        $consulta_2
                );

                $videoInstance = $video->getResult();

                $amountVideos = 0;

                while (isset($videoInstance[$amountVideos]['videoId'])) {
                    $amountVideos++;
                }

                $i = 0;
                while (isset($videoInstance[$i]['videoId'])) {

                    $videoUpdatedate = $videoInstance[$i]['videoUpdatedate'];
                    $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');

                    $videoAmountViews = $videoInstance[$i]['videoAmountViews'];
                    $videoAmountViewsFormat = number_format($videoAmountViews);

                    $videoAmountComments = $videoInstance[$i]['videoAmountComments'];
                    $videoAmountCommentsFormat = number_format($videoAmountComments);

                    if ($videoInstance) {
                        $videoId_Value = $videoInstance[$i]['videoId'];
                        $videoName_Value = $videoInstance[$i]['videoName'];
                        $videoDescription_Value = $videoInstance[$i]['videoDescription'];
                        $videoImage_Value = $videoInstance[$i]['videoImage'];
                        $videoContent_Value = $videoInstance[$i]['videoContent'];
                        $videoUpdatedate_Value = $videoUpdatedateString;
                        $videoAmountViews_Value = $videoAmountViewsFormat;
                        $videoAmountComments_Value = $videoAmountCommentsFormat;
                        $videoLikes_Value = $videoInstance[$i]['videoLikes'];
                        $videoDislikes_Value = $videoInstance[$i]['videoDislikes'];
                        $userId_Value = $videoInstance[$i]['userId'];
                        $userName_Value = $videoInstance[$i]['userName'];
                    } else {
                        $videoId_Value = "_";
                        $videoName_Value = "_";
                        $videoDescription_Value = "_";
                        $videoImage_Value = "_";
                        $videoContent_Value = "_";
                        $videoUpdatedate_Value = "_";
                        $videoAmountViews_Value = "_";
                        $videoAmountComments_Value = "_";
                        $videoLikes_Value = "_";
                        $videoDislikes_Value = "_";
                        $userId_Value = "_";
                        $userName_Value = "_";
                    }

                    $sendData[$i] = array(
                        'videoId' => $videoId_Value,
                        'videoName' => $videoName_Value,
                        'videoDescription' => $videoDescription_Value,
                        'videoImage' => $videoImage_Value,
                        'videoContent' => $videoContent_Value,
                        'videoUpdatedate' => $videoUpdatedate_Value,
                        'videoAmountViews' => $videoAmountViews_Value,
                        'videoAmountComments' => $videoAmountComments_Value,
                        'videoLikes' => $videoLikes_Value,
                        'videoDislikes' => $videoDislikes_Value,
                        'userId' => $userId_Value,
                        'userName' => $userName_Value,
                        'amountVideos' => $amountVideos
                    );
                    $i++;
                }

                if ($i == 0) {
                    $videoId_Value = "_";
                    $videoName_Value = "_";
                    $videoDescription_Value = "_";
                    $videoImage_Value = "_";
                    $videoContent_Value = "_";
                    $videoUpdatedate_Value = "_";
                    $videoAmountViews_Value = "_";
                    $videoAmountComments_Value = "_";
                    $videoLikes_Value = "_";
                    $videoDislikes_Value = "_";
                    $userId_Value = "_";
                    $userName_Value = "_";

                    $sendData[0] = array(
                        'videoId' => $videoId_Value,
                        'videoName' => $videoName_Value,
                        'videoDescription' => $videoDescription_Value,
                        'videoImage' => $videoImage_Value,
                        'videoContent' => $videoContent_Value,
                        'videoUpdatedate' => $videoUpdatedate_Value,
                        'videoAmountViews' => $videoAmountViews_Value,
                        'videoAmountComments' => $videoAmountComments_Value,
                        'videoLikes' => $videoLikes_Value,
                        'videoDislikes' => $videoDislikes_Value,
                        'userId' => $userId_Value,
                        'userName' => $userName_Value,
                        'amountVideos' => 0
                    );
                }

                return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
            } else {
                $videoId_Value = "_";
                $videoName_Value = "_";
                $videoDescription_Value = "_";
                $videoImage_Value = "_";
                $videoContent_Value = "_";
                $videoUpdatedate_Value = "_";
                $videoAmountViews_Value = "_";
                $videoAmountComments_Value = "_";
                $videoLikes_Value = "_";
                $videoDislikes_Value = "_";
                $userId_Value = "_";
                $userName_Value = "_";

                $sendData[0] = array(
                    'videoId' => $videoId_Value,
                    'videoName' => $videoName_Value,
                    'videoDescription' => $videoDescription_Value,
                    'videoImage' => $videoImage_Value,
                    'videoContent' => $videoContent_Value,
                    'videoUpdatedate' => $videoUpdatedate_Value,
                    'videoAmountViews' => $videoAmountViews_Value,
                    'videoAmountComments' => $videoAmountComments_Value,
                    'videoLikes' => $videoLikes_Value,
                    'videoDislikes' => $videoDislikes_Value,
                    'userId' => $userId_Value,
                    'userName' => $userName_Value,
                    'amountVideos' => 0
                );

                return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
            }
        }
    }

    public function storeCurrentKeywordsAction(Request $request) {
        
        if (isset($_SESSION['loginSession'])) {
            $userId = $_SESSION['loginSession'];
        }
        else {
            $userId = 0;
        }
        
        $keywords_entered_2 = $_POST["keyword"];

        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            // me retira (espacios en blanco, saltos de linea, etc) que haya al inicio de la variable $keywords_entered
            $keywords_entered_1 = ltrim($keywords_entered_2);

            // me retira (espacios en blanco, saltos de linea, etc) que haya al final de la variable $keywords_entered
            $keywords_entered = rtrim($keywords_entered_1);

            if ($keywords_entered) {
                $characters_entered_amount = 0;
                $word_entered = array();
                $temporal_word = "";

                for ($i = 0; $i < strlen($keywords_entered); $i++) {
                    //si llegase a existir un espacio entre la frase que se escribió en el buscador,
                    //entonces que me ejecute lo siguiente:
                    if ($keywords_entered[$i] == " ") {
                        $temporal_word = "";
                        $previous = $i - 1;

                        //si el caracter actual y el caracter anterior son espacios en blanco
                        if ($keywords_entered[$previous] == " ") {
                            
                        } else {
                            //si el caracter actual es espacio en blanco,
                            //pero el caracter anterior NO es espacio en blanco
                            $characters_entered_amount++; // creo que esto es pa contar la cantidad de palabras
                        }
                    } else {
                        $temporal_character = $keywords_entered[$i];
                        $temporal_word .= $temporal_character;
                        $word_entered[$characters_entered_amount] = $temporal_word;
                    }
                }

                for ($i = 0; $i <= $characters_entered_amount; $i++) {

                    $existentedKeyword = $em->createQuery(
                            "SELECT k.keywordId, k.keywordContent 
                        FROM HomeBundle:Keyword k 
                        WHERE k.keywordContent = '$word_entered[$i]'"
                    );

                    $existentedKeyword_v = $existentedKeyword->getResult();

                    // validar la existencia del keyword
                    if (isset($existentedKeyword_v[$i]['keywordId'])) {
                        
                    } else {
                        $keyword = new \HomeBundle\Entity\Keyword;
                        $keyword->setKeywordContent($word_entered[$i]);
                        $em->persist($keyword);
                        $em->flush();
                    }

                    ////////////////////////////////////////////////////////////////////

                    $existentedKeywordUser = $em->createQuery(
                            "SELECT k.keywordId, k.keywordContent 
                        FROM HomeBundle:Keyword k 
                        JOIN HomeBundle:Keyworduser ku 
                        WITH k.keywordId = ku.keyword 
                        JOIN HomeBundle:User u 
                        WITH u.userId = ku.user 
                        WHERE k.keywordContent = '$word_entered[$i]' and u.userId = '$userId'"
                    );
                    $existentedKeywordUser_v = $existentedKeywordUser->getResult();

                    // validar la existencia del keyworduser
                    if (isset($existentedKeywordUser_v[0]['keywordId'])) {
                        
                    } else {
                        $stablishedKeyword = $em->createQuery(
                                "SELECT k.keywordId, k.keywordContent 
                            FROM HomeBundle:Keyword k 
                            WHERE k.keywordContent = '$word_entered[$i]'"
                        );
                        $stablishedKeyword_v = $stablishedKeyword->getResult();
                        $keywordId_value = $stablishedKeyword_v[0]['keywordId'];
                        $keyword = $em->getRepository('HomeBundle:Keyword')->findOneByKeywordId($keywordId_value);

                        $stablishedUser = $em->createQuery(
                                "SELECT u.userId 
                            FROM HomeBundle:User u 
                            WHERE u.userId = '$userId'"
                        );
                        $stablishedUser_v = $stablishedUser->getResult();
                        $userId_value = $stablishedUser_v[0]['userId'];
                        $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId_value);



                        $keywordUser = new \HomeBundle\Entity\Keyworduser;
                        $keywordUser->setKeyword($keyword);
                        $keywordUser->setUser($user);
                        $em->persist($keywordUser);
                        $em->flush();
                    }
                }
            }

            $sendData[0] = array(
                '_' => "_"
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

}
