<?PHP

  $CURRENT_VIEW = PUBLIC_VIEW;

  chdir(APP_DATA_PATH);

  $lang = APP_DEF_LANG;
  $lang1 = substr(strip_tags(filter_input(INPUT_GET, "hl")??""), 0, 5);
  if ($lang1 !== PHP_STR) {
    $lang = $lang1;
  }
  $lang2 = substr(strip_tags(filter_input(INPUT_POST, "hl")??""), 0, 5);
  if ($lang2 !== PHP_STR) {
    $lang = $lang2;
  }
  $shortLang = getShortLang($lang);

  $userName = PHP_STR;
  $password = strip_tags(substr(filter_input(INPUT_POST, "password")??"",0,25));
  //if ($password!==PHP_STR) {
    $hash = hash("sha256", $password . APP_SALT, false);
    $ownerNickname="";
    foreach($CONFIG['AUTH'] as $key => $val) {
        $ownerNickname = $CONFIG['AUTH'][$key]['NICKNAME'];
        if ($password===PHP_STR) {
          $hash = "";
          break;
        }
        if ($CONFIG['AUTH'][$key]['HASH'] === $hash) {
          define('USER_NAME', $key);
          $NICKNAME =  $CONFIG['AUTH'][$key]['NICKNAME'];
          $PROFILE_PIC =  $CONFIG['AUTH'][$key]['PROFILE_PIC'];
          $USER_COLOR = $CONFIG['AUTH'][$key]['COLOR'];
          $USER_LOCALE =  $CONFIG['AUTH'][$key]['LOCALE'];
          if ($lang === APP_DEF_LANG) {
            $lang = $USER_LOCALE;
          }
          $shortLang = getShortLang($lang);
          break;
        }
        break;
    }

    if (!defined("USER_NAME")) {
      $password=PHP_STR;	
    }	 
  //}   
 
if ($password === PHP_STR) {
  $CURRENT_VIEW = PUBLIC_VIEW;
} else {
  $CURRENT_VIEW = ADMIN_VIEW;
}

$disc = strip_tags(substr(filter_input(INPUT_POST, "disc")??"",0,35));
$act = strip_tags(substr(filter_input(INPUT_POST, "act")??"",0,1));

//echo("disc=".$disc."<br>");
//echo("act=".$act."<br>");

if ($password !== PHP_STR) {

   // ACTION PRESSED..

   if ($disc !== PHP_STR && $act !== PHP_STR) {

     if ($act === "u") {
       rename(APP_DATA_PATH . DIRECTORY_SEPARATOR .$disc, APP_DATA_PATH . DIRECTORY_SEPARATOR .substr($disc, 0, strlen($disc)-2));
     } else {
       if (substr($disc, strlen($disc)-2, 1) === "_") {
         rename(APP_DATA_PATH . DIRECTORY_SEPARATOR .$disc, APP_DATA_PATH . DIRECTORY_SEPARATOR .substr($disc, 0, strlen($disc)-2)."_$act");
       } else {
         rename(APP_DATA_PATH . DIRECTORY_SEPARATOR .$disc, APP_DATA_PATH . DIRECTORY_SEPARATOR .$disc."_$act");
       }  
     }  
   }
}

?>
<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1"/>
   
<!--<?PHP echo(APP_LICENSE);?>-->  
  
  <title><?PHP echo(APP_TITLE);?></title>

  <link rel="shortcut icon" href="/favicon.ico" />

  <meta name="description" content="Welcome to Msg! Let everyone have its msg."/>
  <meta name="keywords" content="msg,msgbox,voice,machine,on,premise,solution"/>
  <meta name="robots" content="index,follow"/>
  <meta name="author" content="5 Mode"/>
  
  <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="/js/sha.js" type="text/javascript"></script>
  <script src="/js/common.js" type="text/javascript"></script>  
    
     <style>
        .blocked {
           background-color: red;
           color: #FFFFFF;
        }     
        .butAdmin {
           border-radius: 15%;
        }
        .enabled {
           background-color: yellow;
           color: #000000;
        }
        .deleted {
           background-color: darkgray;
           color: #FFFFFF;
        }
        .disabled {
           background-color: #FFFFFF;
           color: #000000;           
        }
        #prex {
          margin:10px;
          margin-right:15px;
          width:96%;
        }
        .rowdisc1 {
           width: 100%;
           max-width:430px;
           height:50px;
           font-size: 15px;
           font-weight: 900;
           veritical-align: middle;
           background-color: #FFFFFF;
           border: 1px solid lightgray;
           color:#000000;
           margin-right:auto;
        }
        .rowdisc2 {
           width: 100%;
           max-width:430px;
           height:50px;
           font-size: 15px;
           font-weight: 900;
           veritical-align: middle;
           background-color: #91C1E0;
           border: 1px solid lightgray;
           color:#000000;
           margin-right:auto;           
        }
     </style>
     
    <link href="/css/style.css?r=<?PHP echo(time());?>" type="text/css" rel="stylesheet"> 
     
   <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
     
 </head> 
 <body style="background:#FFFFFF;margin-top:0px;">

  <div id="header" class="header" style="margin-top:5px;margin-bottom:18px;">
      <a href="http://msg.yourname.com" target="_self" style="color:#000000; text-decoration: none;">&nbsp;<img src="/res/AFlogo.png" align="middle" style="position:relative;top:-5px;width:32px;">&nbsp;<img src="/res/msg-logo.png" height="14px" style="position:relative;top:0px;left:-3px;"></a>&nbsp;&nbsp;<a href="https://github.com/par7133/Msg" style="color:#000000;"><span style="color:#119fe2">on</span> github</a>&nbsp;&nbsp;</a>
  </div>

 <form id="frmUpload" action="/home?hl=<?PHP echo($lang);?>" method="post">

 <?PHP

 if ($CURRENT_VIEW === PUBLIC_VIEW): ?>

   <div class="rowdisc1" style="height:70px;margin-left:20px;margin-top:100px;padding:10px;">
     <?PHP echo(getResource0("PERSONAL MSGBOX", $lang));?><br>
     <?PHP echo(getResource0("This is the personal msgbox of", $lang));?>&nbsp;<?PHP echo($ownerNickname);?>
   </div>

<?PHP else: 

   $pattern = APP_DATA_PATH . DIRECTORY_SEPARATOR . "*";
   $aDisc = glob($pattern, GLOB_ONLYDIR);
   echo("<pre id='prex'>");          
   $i=0;
   $s=0;

   for ($y=1;$y<=2;$y++):
     foreach($aDisc as $disc): 

       if ($i%2===0) {
          $className = "rowdisc1";
       } else {
          $className = "rowdisc2";
       }
       $a = explode("/", $disc);
       $myDisc = $a[count($a)-1];
       
       $myDisc2 = $myDisc;
       
       if (right($myDisc2, 2) === "_a") {
          $myDisc2 = mb_substr($myDisc2, 0, strlen($myDisc2)-2);
       }
       if (right($myDisc2, 2) === "_b") {
          $myDisc2 = mb_substr($myDisc2, 0, strlen($myDisc2)-2);
       }
       if (right($myDisc2, 2) === "_d") {
          $myDisc2 = mb_substr($myDisc2, 0, strlen($myDisc2)-2);
       }

       $bUnauth = true;
       $bAuth = false;
       $bBlock = false;
       $bDelete = false;
       if (right($myDisc, 2) === "_a") {
          $bAuth = true;
       }
       if (right($myDisc, 2) === "_b") {
          $bBlock = true;
       }
       if (right($myDisc, 2) === "_d") {
          $bDelete = true;
       }
       if (!$bAuth && !$bBlock && !$bDelete) {
         $bUnauth = true;
       } else {   
         $bUnauth = false;
       }  
       if ($y === 1) {
          if (!$bUnauth) {
             //$i++; 
             continue;
          }
       } else {
          if ($bUnauth) {
             //$i++; 
             continue;
          }  
          
       }
       $myDisc3 = strtoupper($myDisc2);
       

       if (!$bDelete) {

       echo("<div class=\"". $className ."\">");    
       echo("<br>");
       if  (!$bBlock && !$bDelete) {
         echo("&nbsp;&nbsp;<a href=\"" . $myDisc2 . "\" style=\"text-decoration:none;\">".str_pad($myDisc3, 25, ".")."</a>");
       } else {  
         if ($bBlock) {
           echo("&nbsp;&nbsp;<span style=\"text-decoration:line-through red; color:#000000;\">".str_pad($myDisc3, 25, " ")."</span>");         
         } else {
           echo("&nbsp;&nbsp;<span style=\"text-decoration:line-through darkgray; color:darkgray;\">".str_pad($myDisc3, 25, " ")."</span>");
         }
       }  
       echo("&nbsp;&nbsp;");
       if ($CURRENT_VIEW === ADMIN_VIEW) {
         echo("<input type=\"button\" class=\"butAdmin " . ($bUnauth?"enabled":"disabled") . "\" onclick=\"$('#disc').val('".$myDisc."');$('#act').val('u');frmUpload.submit();\" value=\"U\" title=\"".getResource0("Unhandle", $lang)."\">");
         echo("&nbsp;"); 
       }
       echo("<input type=\"button\" class=\"butAdmin " . ($bAuth?"enabled":"disabled") . "\" onclick=\"$('#disc').val('".$myDisc."');$('#act').val('a');frmUpload.submit();\" value=\"A\" title=\"".getResource0("Approved", $lang)."\">");
       echo("&nbsp;"); 
       echo("<input type=\"button\" class=\"butAdmin " . ($bBlock?"blocked":"disabled") . "\" onclick=\"$('#disc').val('".$myDisc."');$('#act').val('b');frmUpload.submit();\" value=\"B\" title=\"".getResource0("Ban", $lang)."\">");
       echo("&nbsp;");
       echo("<input type=\"button\" class=\"butAdmin " . ($bDelete?"deleted":"disabled") . "\" onclick=\"$('#disc').val('".$myDisc."');$('#act').val('d');frmUpload.submit();\" value=\"D\" title=\"".getResource0("Delete", $lang)."\">");
       echo("</div>");

       $s++;
       
       }
   
       $i++;                  
     endforeach;
   endfor;
   
   if ($s === 0) {
     echo(getResource0("No message found.", $lang));
   }

   echo("</pre>");
   
   echo("<br>");
   echo("<div id =\"footerfaq\" style=\"position:relative;float:right;height:40px;font-weight:900;\"><a href=\"/faq.html\">FAQ</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>");  
?>

    <input id="disc" name="disc" type="hidden" value="">
    <input id="act" name="act" type="hidden" value="">

<?PHP endif; ?>

    <div id="passworddisplay">
        <br>  
        &nbsp;&nbsp;<input id="Password" name="password" type="password" placeholder="password" value="<?PHP echo($password);?>" autocomplete="off">&nbsp;<input id="Go" type="submit" value="<?PHP echo(getResource0("Go", $lang));?>"><br>
        &nbsp;&nbsp;<input id="Salt" type="text"  placeholder="salt" autocomplete="off">
        <div style="text-align:center;">
            <a id="hashMe" href="#" onclick="showEncodedPassword();"><?PHP echo(getResource0("Hash Me", $lang));?>!</a>
        </div>
    </div>

    <input type="hidden" name="hl" value="<?PHP echo($lang);?>">

</form>

  <div id="footterCont">&nbsp;</div>
  <div id="footer" style="position:relative;;">
    <div style="float:left">
        <select id="cbLang" onchange="changeLang(this);">
          <option value="en-US" <?PHP echo(($lang==PHP_EN?"selected":""));?>>en</option>
          <option value="it-IT" <?PHP echo(($lang==PHP_IT?"selected":""));?>>it</option>
          <option value="zh-CN" <?PHP echo(($lang==PHP_CN?"selected":""));?>>cn</option>
        </select> 
    </div>
   <span style="background:#FFFFFF; opacity:0.7;">&nbsp;&nbsp;A <a href="http://5mode.com" class="aaa">5 Mode</a> project and <a href="http://demo.5mode.com" class="aaa">WYSIWYG</a> system. CC</span></div>
  
<script>

function changeLang(tthis) {
  window.open("/?hl="+$(tthis).val(),"_self");
}

function showEncodedPassword() {
  if ($("#Password").val() === "") {
    $("#Password").addClass("emptyfield");
    return;  
  }
  //if ($("#Salt").val() === "") {
  //  $("#Salt").addClass("emptyfield");
  //  return;  
  //}	   	
  passw = encryptSha2( $("#Password").val() + $("#Salt").val());
  msg = "Please set your hash in the config file with this value";
  alert(msg + "\n\n" + passw);	
}

function setFooterPos() {
  if (document.getElementById("footerCont")) {
    tollerance = 16;
    //$("#footerfaq").css("top", parseInt( window.innerHeight - $("#footerfaq").height() - tollerance ) + "px");
    $("#footerCont").css("top", parseInt( window.innerHeight - $("#footerCont").height() - tollerance ) + "px");
    $("#footer").css("top", parseInt( window.innerHeight - $("#footer").height() - tollerance ) + "px");
  }
}

function setContentPos2() {                    
  h=parseInt(window.innerHeight);
  w=parseInt(window.innerWidth);

  mytop = parseInt(h - ($("#passworddisplay").height() + 80));
  $("#passworddisplay").css("top", mytop+"px");
  $("#passworddisplay").show();

  $("#prex").css("height", parseInt(h - 170) + "px");
  $("#frmUpload").css("height", parseInt(h - 230) + "px");

} 

 function hidePassword() {
  //$("#passworddisplay").css("visibility","hidden");
  $("#passworddisplay").hide();
 }  

window.addEventListener("load", function() {

  setTimeout("setContentPos2()", 200);
  //setTimeout("setFooterPos()", 200);
  setTimeout("hidePassword()", 12000);

}, true);

window.addEventListener("resize", function() {

  setTimeout("setContentPos2()", 200);
  //setTimeout("setFooterPos()", 200);
  setTimeout("hidePassword()", 12000);

}, true);

</script>

</body>
</html>
