//super global variables
var current_video_id = "";
var current_video_name = "";
var current_video_description = "";
var current_video_image = "";
var current_video_content = "";
var current_video_updateDate = "";
var current_video_amount_views = "";
var current_video_amount_comments = "";
var current_video_likes = "";
var current_video_dislikes = "";

var current_specificlistId = "";
var current_videoPosition = "";

//previous and next video
var next_video_image = "";
var previous_video_image = "";

//screen
var total_screen_mode = "incomplete";

//lyrics
var lyricsPosition = 0;


//delete next variable
var firstLineValue = 150;
var secondLineValue = 100;
var thirdLineValue = 50;
var fourthLineValue = 0;
var fifthLineValue = -50;
    
var d_estrofas = 0;
var e_palabras = 0;
    

var estrofaAmount = 40; // es la cantidad de estrofas
var palabraAmount = 40; // este valor varia segun la estrofa... 



var currentVideo_playing = setInterval(function() {
}, 1000);



currentVideo_playingWithFormat = setInterval(function() {
}, 1000);

var video_speed = 1;

var lyricsWord = new Array(estrofaAmount);
for (var i=0; i<lyricsWord.length; i++)
{
    lyricsWord[i] = new Array(palabraAmount);
    
    for (var j=0; j<lyricsWord[i].length; j++)
    {
        lyricsWord[i][j] = new Array(12);
    }
}


function showVideo(
            videoId, 
            videoName, 
            videoDescription, 
            videoImage, 
            videoContent, 
            videoUpdateDate, 
            videoAmountViews, 
            videoAmountComments, 
            videoLikes, 
            videoDislikes 
        )
{
    clearInterval(currentVideo_playing); // editLyricsBundle
    clearInterval(currentVideo_playingWithFormat); // playBannerBundle
    
    // me genera los ciclos repetitivos para el video actual

    current_video_id = videoId;
    current_video_name = videoName;
    current_video_description = videoDescription;
    current_video_image = videoImage;
    current_video_content = videoContent;
    current_video_updateDate = videoUpdateDate;
    current_video_amount_views = videoAmountViews;
    current_video_amount_comments = videoAmountComments;
    current_video_likes = videoLikes;
    current_video_dislikes = videoDislikes;
    
    var my_video = document.getElementById("my_video_environment");
    my_video.innerHTML =
        "<video id='my_video' width='100%' autoplay='true'>" +
        "<source src='files/videos/" + videoContent + "') }}' type='video/mp4'> " +
        "</video>";
    
    
    get_video_lyric(); // ShowLyricsBundle
    prepare_edit_video_lyrics(); // EditLyricsBundle
    showCurrentTime_withFormat(); // PlayBannerBundle
    showCurrentTime_withoutFormat(); // EditLyricsBundle
    changeVideoSpeed(); // PlayBannerBundle
    showDuration(); // PlayBannerBundle
     

    
    
    
    
    
//    crear una variable global que me asigne la velocidad del video



    
//    ALL INFORMATION ABOUT THE VIDEO: 
//    update the options about the respectly video
//    SongBundle: Comment section, user's information, 
//    ArtistBundle: Available only with login session 
//    lyrics section
}


//FUNCTION THAT CALL DIFFERENT METHODS WHEN USER PLAY A NEW VIDEO
//-songBundle (and its subBundles: @CommentVideo)
//-artistBundle (and its subBundles: )
//-presentationBundle (and its subBundles: )

//METHODS THAT ARE AVAILABLE ONLY WHEN USER LOGIN
//-profileBundle (and its subBundles:  )
//    @ListBundle: Available only with login session (default option)... event cathed when user click on the icon
//    @EditProfile: Available only with login session... event cathed when user click on the icon
//    @DataminingBundle: Available only with login session... event cathed when user click on the icon
//    @HistoryBundle: Available only with login session... event cathed when user click on the icon
//    @UploadBundle: Available only with login session... event cathed when user click on the icon
//    @LyricsBundle:Available only with login session... event cathed when user click on the icon

//Can play VideoBundle
//PODER REPRODUCIR EL OPTIONVIDEOBUNDLE DIRECTAMENTE



function updateVideoInformation(videoName, userName)
{
    var songIconButton = document.getElementById("songIconButton");
    var artistIconButton = document.getElementById("artistIconButton");

    songIconButton.innerHTML = videoName;
    artistIconButton.innerHTML = userName;
}

function highlightPortrait(videoId)
{
    document.getElementById(videoId).style.transitionProperty = "all";
    document.getElementById(videoId).style.transitionDuration = "0.4s";
    document.getElementById(videoId).style.opacity = 1;
}

function hidePortrait(videoId)
{
    document.getElementById(videoId).style.transitionProperty = "all";
    document.getElementById(videoId).style.transitionDuration = "0.4s";
    document.getElementById(videoId).style.opacity = 0.4;
}

    
function configureLyricswordTimeWithFormat(time) {
    var minutes = parseInt(time / 60, 10);
    var seconds = time % 60;
    var minutesString = "";
    var secondsString = "";

    if (minutes<=9)
    {
        minutesString = "0"+minutes;
    }
    else
    {
        minutesString = ""+minutes;
    }

    if (seconds<=9)
    {
        secondsString = "0"+seconds;
    }
    else
    {
        secondsString = ""+seconds;
    }

    var newValue = minutesString + ":" + secondsString.substring(0, 2);
    return newValue;
}

function showMessage_EmergentWindow(message)
{
        var respectlyFormId = document.getElementById("emergentWindow");

        respectlyFormId.style.width = "100%";
        respectlyFormId.style.height = "100%";
        respectlyFormId.style.opacity = "0.9";
        respectlyFormId.style.zIndex = "20";
        respectlyFormId.style.position = "absolute";
        respectlyFormId.style.color = "gray";
        respectlyFormId.style.backgroundColor = "white";
        respectlyFormId.style.overflowY = "scroll";
        
        respectlyFormId.innerHTML = 
        "<center>"+
        "<br><br><br><br><br><br>"+
        "<table width='300px' border='0'>"+
        
            "<tr>"+
                "<td colspan='2' align='right'>"+
                "<div id='close_EmergentWindow' style='cursor:pointer; background-color:red; padding:5px; opacity: 0.5; color: white; width:40px; height:30px;'><center>X</center></div>"+
                "</td>"+
            "</tr>"+

            "<tr>"+
                "<td>"+
                    "<br>"+message+"<br><br>"+
                "</td>"+
            "</tr>"+

            "<tr height='40px'>"+
                "<td colspan='2'>"+
                
                "<center>"+
                    "<div id='accept_EmergentWindow' style='cursor:pointer; background-color:#1ab7ea; padding:5px; opacity: 0.5; width:60px; height:30px;'>"+
                    "ACCEPT"+
                    "</div>"+
                "</center>"+

                
                "</td>"+
            "</tr>"+
            
        "</table>"+
        
        "</center>";
                
        $('#close_EmergentWindow').click(function () {
        var respectlyFormId = document.getElementById("emergentWindow");

            respectlyFormId.style.width = "100%";
            respectlyFormId.style.height = "100%";
            respectlyFormId.style.opacity = "0";
            respectlyFormId.style.zIndex = "1";
            respectlyFormId.style.position = "absolute";

            respectlyFormId.innerHTML = "";
        });
        
                
        $('#accept_EmergentWindow').click(function () {
        var respectlyFormId = document.getElementById("emergentWindow");

            respectlyFormId.style.width = "100%";
            respectlyFormId.style.height = "100%";
            respectlyFormId.style.opacity = "0";
            respectlyFormId.style.zIndex = "1";
            respectlyFormId.style.position = "absolute";

            respectlyFormId.innerHTML = "";
        });
        
}