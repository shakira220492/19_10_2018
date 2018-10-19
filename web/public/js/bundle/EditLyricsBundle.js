var position_lyrics = 0;

var d_estrofas_EditLyrics = 0;
var e_palabras_EditLyrics = 0;

estrofaAmount_EditLyrics = 40;
palabraAmount_EditLyrics = 40;

var lyricsWord_EditLyrics = new Array(estrofaAmount_EditLyrics);
for (var i=0; i<lyricsWord_EditLyrics.length; i++)
{
    lyricsWord_EditLyrics[i] = new Array(palabraAmount_EditLyrics);
    
    for (var j=0; j<lyricsWord_EditLyrics[i].length; j++)
    {
        lyricsWord_EditLyrics[i][j] = new Array(12);
    }
}


//////////////////////////////////////////////////////////////////////////////////////////

var moveAutomaticallyVideo = 0; // "0" don't "1" yes 

//////////////////////////////////////////////////////////////////////////////////////////

var speed = 0;
var speed_millisecond = 0;

//////////////////////////////////////////////////////////////////////////////////////////
var mouse_status = 0; // "0" si NO se puede dibujar, "1" si SI se puede dibujar

var firstFrameId = 0;
var middleFrameId = 0;
var previousFrameId = 0;
var lastFrameId = 0;

var firstFrameTime = 0;
var middleFrameTime = 0;
var previousFrameTime = 0;
var lastFrameTime = 0;

var lyricsWordId = 0;

var currentWord = "";
var currentLyricsLine = 0;
var currentLyricsWordId = 0;

var availableId = 0;

function draw_word()
{
    
    
    //IMPORTANTE:
    //setAttribute -> lyricsWordId en draw_word_frames();
    
    
    
    var respectlyValue = 0;
    
    // esta funcion me pinta los frames que no quedaron pintados
    draw_word_frames();
    
    // esta funcion me dibuja los bordes
    draw_word_border();
    
    // esta funcion me dibuja el input y las demás opciones
    draw_word_content();
}

function draw_word_frames()
{
    if (firstFrameId > lastFrameId)
    {
        for (dwf=lastFrameId; dwf<=firstFrameId; dwf++)
        {
            respectlyValue = dwf;
            var frameId = "frame"+respectlyValue;
            var thisWordId = "word_lyrics"+respectlyValue;
            var frame = document.getElementById(frameId);
            var word_lyrics = document.getElementById(thisWordId);

            word_lyrics.setAttribute("draw_status", "unavailable");
            word_lyrics.setAttribute("start_id", lastFrameId);
            word_lyrics.setAttribute("end_id", firstFrameId);
            word_lyrics.setAttribute("start_time", lastFrameTime);
            word_lyrics.setAttribute("end_time", firstFrameTime);
            word_lyrics.setAttribute("word_id", currentLyricsWordId);
            
            word_lyrics.style.opacity = "0.7";
            word_lyrics.style.backgroundColor = "white";
            word_lyrics.style.cursor = "not-allowed";
            
            document.getElementById("write_lyricsWord_frame"+dwf).value = currentWord;
            document.getElementById("write_lyricsLine_frame"+dwf).value = currentLyricsLine;            
            
            var menu_lyricsWord_frame = "menu_lyricsWord_frame"+dwf;
            var menu_lyricsWord_frame_e = document.getElementById(menu_lyricsWord_frame);
            menu_lyricsWord_frame_e.style.display = "block";
        }
    } else if (firstFrameId <= lastFrameId)
    {
        for (dwf=firstFrameId; dwf<=lastFrameId; dwf++)
        {
            respectlyValue = dwf;
            var frameId = "frame"+respectlyValue;
            var thisWordId = "word_lyrics"+respectlyValue;
            var frame = document.getElementById(frameId);
            var word_lyrics = document.getElementById(thisWordId);

            word_lyrics.setAttribute("draw_status", "unavailable");
            word_lyrics.setAttribute("start_id", firstFrameId);
            word_lyrics.setAttribute("end_id", lastFrameId);
            word_lyrics.setAttribute("start_time", firstFrameTime);
            word_lyrics.setAttribute("end_time", lastFrameTime);
            word_lyrics.setAttribute("word_id", currentLyricsWordId);
            
            word_lyrics.style.opacity = "0.7";
            word_lyrics.style.backgroundColor = "white";
            word_lyrics.style.cursor = "not-allowed";
            
            document.getElementById("write_lyricsWord_frame"+dwf).value = currentWord;
            document.getElementById("write_lyricsLine_frame"+dwf).value = currentLyricsLine;
            
            
            var menu_lyricsWord_frame = "menu_lyricsWord_frame"+dwf;
            var menu_lyricsWord_frame_e = document.getElementById(menu_lyricsWord_frame);
            menu_lyricsWord_frame_e.style.display = "block";
        }
    }
}

function draw_word_border()
{
    if (firstFrameId > lastFrameId)
    {
        var firstWord_lyrics = "word_lyrics"+lastFrameId;
        var lastWord_lyrics = "word_lyrics"+firstFrameId;
        
        var firstDelete_only_frame = "delete_only_frame"+lastFrameId;
        var lastDelete_only_frame = "delete_only_frame"+firstFrameId;
        
        var firstAdd_only_frame = "add_only_frame"+lastFrameId;
        var lastAdd_only_frame = "add_only_frame"+firstFrameId;
    } else if (firstFrameId <= lastFrameId)
    {
        var firstWord_lyrics = "word_lyrics"+firstFrameId;
        var lastWord_lyrics = "word_lyrics"+lastFrameId;
        
        var firstDelete_only_frame = "delete_only_frame"+firstFrameId;
        var lastDelete_only_frame = "delete_only_frame"+lastFrameId;
        
        var firstAdd_only_frame = "add_only_frame"+firstFrameId;
        var lastAdd_only_frame = "add_only_frame"+lastFrameId;
    }
    
    document.getElementById(firstWord_lyrics).style.borderTop = "1px solid #1ab7ea";
    document.getElementById(lastWord_lyrics).style.borderBottom = "1px solid white";
    
    document.getElementById(firstDelete_only_frame).style.display = "block";
    document.getElementById(lastDelete_only_frame).style.display = "block";
    
    document.getElementById(firstAdd_only_frame).style.display = "block";
    document.getElementById(lastAdd_only_frame).style.display = "block";
}

function draw_word_content()
{
    if (firstFrameId === lastFrameId)
    {
        middleFrameId = firstFrameId;
    } else
    {
        middleFrameId = parseInt((lastFrameId + firstFrameId)/2);
    }
    
    var menu_lyricsWord_frame = "menu_lyricsWord_frame"+middleFrameId;
    var menu_lyricsWord_frame_e = document.getElementById(menu_lyricsWord_frame);
    menu_lyricsWord_frame_e.style.display = "block";
}

function draw_frame()
{
    var previousWordId = "word_lyrics"+previousFrameId;
    var previous_word_lyrics = document.getElementById(previousWordId);

    var thisWordId = "word_lyrics"+lastFrameId;
    var this_word_lyrics = document.getElementById(thisWordId);


    if (firstFrameId < lastFrameId)
    {
        if (previousFrameId < lastFrameId)
        {
            // no borrar el previous
        } else if (previousFrameId > lastFrameId)
        {
            // borrar el previous
            previous_word_lyrics.style.backgroundColor = "gray";
        }
    } else if (firstFrameId > lastFrameId)
    {
        if (previousFrameId < lastFrameId)
        {
            // borrar el previous 
            previous_word_lyrics.style.backgroundColor = "gray";
        } else if (previousFrameId > lastFrameId)
        {
            // no borrar el previous
        }
    } else if (firstFrameId === lastFrameId && 
            (previousFrameId - 1 === lastFrameId ||
            previousFrameId + 1 === lastFrameId))
    {
        if (previousFrameId < lastFrameId)
        {
            // borrar el previous 
            previous_word_lyrics.style.backgroundColor = "gray";
        } else if (previousFrameId > lastFrameId)
        {
            // borrar el previous
            previous_word_lyrics.style.backgroundColor = "gray";
        }
    }

    // en cualquiera de los casos siempre se dibuja sobre el actual frame
    this_word_lyrics.style.backgroundColor = "white";
}

function displace_video(time)
{
    var v = document.getElementById("my_video");
    var respectlyValueFloat = parseFloat(time);
    v.currentTime = respectlyValueFloat;
}

function delete_lyricsWord()
{
    var respectlyValue = 0;
    
    // esta funcion me borra los frames que de la palabra
}

function delete_word_frames(j, i)
{
    var frameId = "frame"+j;
    var frame = document.getElementById(frameId);

    var word_lyricsId = "word_lyrics"+j;
    var word_lyrics = document.getElementById(word_lyricsId);
    
    var start_timeId = "start_time"+j;
    var start_time = document.getElementById(start_timeId);
    
    
    
    var startId = parseInt(word_lyrics.getAttribute("start_id"));
    var endId = parseInt(word_lyrics.getAttribute("end_id"));
    var startTime = parseFloat(word_lyrics.getAttribute("start_time"));
    var endTime = parseFloat(word_lyrics.getAttribute("end_time"));

//    alert("\n j... "+j+
//          "\n i... "+i+
//          "\n firstFrameId... "+firstFrameId+
//          "\n middleFrameId... "+middleFrameId+
//          "\n lastFrameId... "+lastFrameId+
//          "\n startId... "+startId+
//          "\n endId... "+endId+
//          "\n startTime... "+startTime+
//          "\n endTime... "+endTime);
  
    for (i=startId; i<=endId; i++)
    {
        var start_timeId = "start_time"+i;
        var word_lyricsId = "word_lyrics"+i;
        var frameId = "frame"+i;
        var delete_only_frameId = "delete_only_frame"+i;
        var add_only_frameId = "add_only_frame"+i;
        
        var frameObject = document.getElementById(frameId);
        var start_timeObject = document.getElementById(start_timeId);
        var word_lyricsObject = document.getElementById(word_lyricsId);
        var delete_only_frameObject = document.getElementById(delete_only_frameId);
        var add_only_frameObject = document.getElementById(add_only_frameId);
        
        
//        frameObject.style.opacity = "0.4";
        start_timeObject.style.backgroundColor = "gray";
        start_timeObject.style.cursor = "pointer";
        start_timeObject.style.opacity = "0.4";
        start_timeObject.style.border = "0px solid black";

        word_lyricsObject.setAttribute("draw_status", "available");
        word_lyricsObject.style.backgroundColor = "gray";
        word_lyricsObject.style.cursor = "pointer";
        word_lyricsObject.style.opacity = "0.4";
        word_lyricsObject.style.border = "0px solid black";
        word_lyricsObject.style.borderLeft = "1px solid #1ab7ea";
        
        delete_only_frameObject.style.display = "none";
        add_only_frameObject.style.display = "none";
        
        var menu_lyricsWord_frame = "menu_lyricsWord_frame"+i;
        var menu_lyricsWord_frame_e = document.getElementById(menu_lyricsWord_frame);
        menu_lyricsWord_frame_e.style.display = "none";
    }
}
