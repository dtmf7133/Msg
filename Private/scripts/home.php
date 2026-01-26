<?php

/**
 * Copyright 2021, 2024 5 Mode
 *
 * This file is part of Msg.
 *
 * Msg is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Msg is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.  
 * 
 * You should have received a copy of the GNU General Public License
 * along with Msg. If not, see <https://www.gnu.org/licenses/>.
 *
 * home.php
 * 
 * Home of Msg.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode
 */

 // CONSTANTS AND VARIABLE DECLARATION      
 $CURRENT_VIEW = PUBLIC_VIEW;
 
 $CUDOZ = 1;
 
 $BUD_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . BUD_NAME;
 // XXX
 if (!is_readable($BUD_PATH)) {
    if (is_readable($BUD_PATH."_a")) {
      $BUD_PATH = $BUD_PATH . "_a";    
    } 
    
    if (is_readable($BUD_PATH."_b") || is_readable($BUD_PATH."_d")) {
      exit(1);
      //$BUD_PATH = $BUD_PATH . "_b";     
    } 
 }

 $CV_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "cv";      
 $FRIENDS_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "friends";      
 $BLOG_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "blog";      
 $GALLERY_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "gallery";      
 $MAGICJAR1_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "magicjar1";      
 $MAGICJAR2_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "magicjar2";
 $MAGICJAR3_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "magicjar3";
 
 $profilePic = APP_DEF_PROFILE_PIC;
 
 
 // PAGE PARAMETERS
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

 $blogSP = (int)substr(strip_tags(filter_input(INPUT_GET, "blogSP")??""), 0, 5);

$userName = PHP_STR;
$password = strip_tags(substr(filter_input(INPUT_POST, "password")??"",0,25));
if ($password!==PHP_STR) {
  $hash = hash("sha256", $password . APP_SALT, false);

  foreach($CONFIG['AUTH'] as $key => $val) {
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
  }

  if (!defined("USER_NAME")) {
    $password=PHP_STR;	
  }	 
}

if ($password===PHP_STR): ?>
<?PHP if (defined("BUD_NAME") && BUD_NAME!==""):?>
<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1"/>
   
<!--<?PHP echo(APP_LICENSE);?>-->  
  
  <title><?PHP echo(APP_TITLE);?></title>

  <link rel="shortcut icon" href="/favicon.ico" />

  <meta name="description" content="Welcome to FloatingBuds! Let everyone have its conversation."/>
  <meta name="keywords" content="FloatingBuds,conversations,floating,buds,on,premise,solution"/>
  <meta name="robots" content="index,follow"/>
  <meta name="author" content="5 Mode"/>
  
  <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="/js/sha.js" type="text/javascript"></script>
  <script src="/js/common.js" type="text/javascript"></script>  
    
  <link href="/css/style.css?r=<?PHP echo(time());?>" type="text/css" rel="stylesheet">
  
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
   
</head>
<body style="background:#FFFFFF;">
<form action="/<?PHP echo(str_replace(".","~",BUD_NAME));?>" method="post" target="_self" style="width:100%;height:1000px;text-align:center;">
<?PHP else:
die("Invalid CHAT NAME");
 endif; ?>
   <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <span id="labLogin"><?PHP echo(getResource0("Login with your password:", $lang));?></span><br>
  <input id="password" name="password" type="password" value="" maxlength="25" placeholder="PASSWORD" style="color:lightgray">
  <input name="hl" type="hidden" value="<?PHP echo($lang);?>" maxlength="5">
</form>
</body>
</html>
<?PHP
  exit(0);
endif;  

   
// if ($password !== PHP_STR) {
//   $CURRENT_VIEW = ADMIN_VIEW;
// } else {
//   $CURRENT_VIEW = PUBLIC_VIEW;
//} 

 $magicJar1 = (int)substr(strip_tags(filter_input(INPUT_POST, "txtMagicJar1")??""), 0, 1);
 $magicJar2 = (int)substr(strip_tags(filter_input(INPUT_POST, "txtMagicJar2")??""), 0, 1);
 $magicJar3 = (int)substr(strip_tags(filter_input(INPUT_POST, "txtMagicJar3")??""), 0, 1);

 
 function uploadNewRes() {

   global $BUD_PATH;
   global $CV_PATH;      
   global $FRIENDS_PATH;      
   global $BLOG_PATH;      
   global $GALLERY_PATH;      
   global $MAGICJAR1_PATH;      
   global $MAGICJAR2_PATH;
   global $MAGICJAR3_PATH;
   global $magicJar1;
   global $magicJar2;
   global $magicJar3;

   //echo_ifdebug(true, "BUD_PATH#1=");
   //echo_ifdebug(true, $BUD_PATH);
   
   if (!empty($_FILES['files']['tmp_name'][0]) ||  !empty($_FILES['filesdd']['tmp_name'][0])) {
      
     $uploads = (array)fixMultipleFileUpload($_FILES['files']);
     if ($uploads[0]['error'] === PHP_UPLOAD_ERR_NO_FILE) {
       $uploads = (array)fixMultipleFileUpload($_FILES['filesdd']);
     }   
     
     //if ($uploads[0]['error'] === PHP_UPLOAD_ERR_NO_FILE) {
     //  echo("WARNING: No file uploaded.");
     //  return;
     //} 

     $google = "abcdefghijklmnopqrstuvwxyz";
     if (count($uploads)>strlen($google)) {
       echo("WARNING: Too many uploaded files."); 
       return;
     }

     $i=1;
     foreach($uploads as &$upload) {
		
       switch ($upload['error']) {
       case PHP_UPLOAD_ERR_OK:
         break;
       case PHP_UPLOAD_ERR_NO_FILE:
         echo("WARNING: One or more uploaded files are missing.");
         return;
       case PHP_UPLOAD_ERR_INI_SIZE:
         echo("WARNING: File exceeded INI size limit.");
         return;
       case PHP_UPLOAD_ERR_FORM_SIZE:
         echo("WARNING: File exceeded form size limit.");
         return;
       case PHP_UPLOAD_ERR_PARTIAL:
         echo("WARNING: File only partially uploaded.");
         return;
       case PHP_UPLOAD_ERR_NO_TMP_DIR:
         echo("WARNING: TMP dir doesn't exist.");
         return;
       case PHP_UPLOAD_ERR_CANT_WRITE:
         echo("WARNING: Failed to write to the disk.");
         return;
       case PHP_UPLOAD_ERR_EXTENSION:
         echo("WARNING: A PHP extension stopped the file upload.");
         return;
       default:
         echo("WARNING: Unexpected error happened.");
         return;
       }
      
       if (!is_uploaded_file($upload['tmp_name'])) {
         echo("WARNING: One or more file have not been uploaded.");
         return;
       }
      
       // name	 
       $name = (string)substr((string)filter_var($upload['name']), 0, 255);
       if ($name == PHP_STR) {
         echo("WARNING: Invalid file name: " . $name);
         return;
       } 
       $upload['name'] = $name;
       
       // fileType
       $fileType = substr((string)filter_var($upload['type']), 0, 30);
       $upload['type'] = $fileType;	 
       
       // tmp_name
       $tmp_name = substr((string)filter_var($upload['tmp_name']), 0, 300);
       if ($tmp_name == PHP_STR || !file_exists($tmp_name)) {
         echo("WARNING: Invalid file temp path: " . $tmp_name);
         return;
       } 
       $upload['tmp_name'] = $tmp_name;
       
       //size
       $size = substr((string)filter_var($upload['size'], FILTER_SANITIZE_NUMBER_INT), 0, 12);
       if ($size == "") {
         echo("WARNING: Invalid file size.");
         return;
       } 
       $upload["size"] = $size;

       $tmpFullPath = $upload["tmp_name"];
       
       $originalFilename = pathinfo($name, PATHINFO_FILENAME);
       $originalFileExt = pathinfo($name, PATHINFO_EXTENSION);
       $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));

       $date = date("Ymd-His");
       $rnd = mt_rand(1000000000, 9999999999);    
       
       if ($originalFileExt!==PHP_STR) {
         $destFileName = $date . "-" . $rnd . substr($google, $i-1, 1) . "|" . USER_NAME . "|" . str_replace(" ", "_", $originalFilename) . ".$fileExt";
       } else {
         return; 
       }	   

       //$CV_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "cv";      
       //$FRIENDS_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "friends";      
       //$BLOG_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "blog";      
       //$GALLERY_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "gallery";      
       
       $destPaths = [];
       $destFullPaths = [];
       
       if ($magicJar1 != 0) {
         $destPaths[] = $MAGICJAR1_PATH;
         $destFullPaths[] = $destPaths[count($destPaths)-1] . DIRECTORY_SEPARATOR . $destFileName;
       }
       if ($magicJar2 != 0) {
         $destPaths[] = $MAGICJAR2_PATH;
         $destFullPaths[] = $destPaths[count($destPaths)-1] . DIRECTORY_SEPARATOR . $destFileName;
       }
       if ($magicJar3 != 0) {
         $destPaths[] = $MAGICJAR3_PATH;
         $destFullPaths[] = $destPaths[count($destPaths)-1] . DIRECTORY_SEPARATOR . $destFileName;
       }
       
       if (empty($destPaths)) {
       
          switch ($fileExt) {
            //case "doc":
            //case "docx":
            //case "pdf":
            //  $destPaths[] = $CV_PATH;
            //  break;
            case "mp3":
              $destPaths[] = $BLOG_PATH;
              break;
            case "png":
            case "jpg":
            case "jpeg":
            case "gif":
            case "webp":
              $destPaths[] = $GALLERY_PATH;
              break;
            default:
              $destPaths[] = $MAGICJAR1_PATH;
              break;
          }
          $destFullPaths[] = $destPaths[0] . DIRECTORY_SEPARATOR . $destFileName;
       }     
       
       $iPath = 0;
       foreach($destFullPaths as $destFullPath) {
       
          if (file_exists($destFullPath)) {
            echo("WARNING: destination already exists");
            exit(1);
          }	   

          if (filesize($tmpFullPath) > APP_FILE_MAX_SIZE) {
            echo("ERROR: file size(" . filesize($tmpFullPath) . ") exceeds app limit:" . APP_FILE_MAX_SIZE);
            exit(1);
          }
          
          if (!is_readable($BUD_PATH)) {
            mkdir($BUD_PATH, 0777); 
          }

          if (!is_readable($destPaths[$iPath])) {
            mkdir($destPaths[$iPath], 0777); 
          }

          $pattern = $destPaths[$iPath] . DIRECTORY_SEPARATOR . "*" . "|" . str_replace(" ", "_", $originalFilename) . ".$fileExt";
          $aExistingPaths = glob($pattern);
          if (!empty($aExistingPaths)) {
            continue;
          }

          copy($tmpFullPath, $destFullPath);

          $iPath++;
       }   
          
       // Cleaning up..
      
       // Delete the tmp file..
       unlink($tmpFullPath); 
       
       $i++;
        
     }	 
   } else {
     //echo("WARNING: No file uploaded (err-pip-po).");
   }
 }

 function writeFriends() {
   
   global $FRIENDS_PATH; 
   
   $destPath = $FRIENDS_PATH;
   
   $s = filter_input(INPUT_POST, "f")??"";
   $s = strip_tags($s);
   if ($s != PHP_STR) {
   //echo($s);
   //exit(0);
     $friends=explode("|", $s);
     
     if (!is_readable($destPath)) {
       mkdir($destPath, 0777); 
     }
     
     foreach($friends as $friend) {
       $a = explode("://",$friend);
       $s = $a[1];
       $a = explode("/", $s); 
       $friendName = $a[0] . ".txt";
       
       file_put_contents($destPath . DIRECTORY_SEPARATOR . $friendName, $friend);
     }
     
   }  
 }
 
 function grabProfileImage() {
   
   global $GALLERY_PATH;
   
   $pattern = $GALLERY_PATH . DIRECTORY_SEPARATOR . "*";
   $aImagePaths = glob($pattern);
   if (isset($aImagePaths[0])) {
     $retval = basename($aImagePaths[0]);
   } else {
     $retval = null;
   }
   return $retval;
   
 }
 
 function startApp() {
   global $CURRENT_VIEW;
   global $profilePic;
   
   if ($CURRENT_VIEW == $CURRENT_VIEW) {
   
     uploadNewRes();
   
     writeFriends();
  
   }
     
   $profilePic = grabProfileImage() ?? APP_DEF_PROFILE_PIC;
   //echo("profile pic=" . $profilePic);
  
 }  
 startApp();
 
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
  <meta name="author" content="NuMode"/>
  
  <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="/js/sha.js" type="text/javascript"></script>
  <script src="/js/common.js" type="text/javascript"></script>  
    
  <link href="/css/style.css?r=<?PHP echo(time());?>" type="text/css" rel="stylesheet">
  
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
   
</head>
  
<?PHP if ($CURRENT_VIEW == ADMIN_VIEW): ?>    
  
  <body style="background:url('/res/bg1.jpg') no-repeat; background-size: cover; background-attachment: fixed; background-position: center;">
  
   <div id="AFHint" style="z-index:0;">
        <button type="button" class="close" aria-label="Close" onclick="closeMe(this);" style="position:relative; top:5px; left:-7px;">
           <span aria-hidden="true" style="color:black; font-weight:900;">&times;</span>
       </button>
       <br>  
      <span onclick="showHowTo();"><?PHP echo(getResource0("How-to: Manage your avatars in Avatar Free", $lang));?></span>
      <br><br>
   </div>     

  <form id="frmUpload" role="form" method="post" action="/<?PHP echo(BUD_NAME);?>?hl=<?PHP echo($lang);?>" target="_self" enctype="multipart/form-data">  
    
  <div class="dragover" dropzone="copy">  
    
   <div id="fireupload" onclick="$('#files').click()">
       <img id="picavatar" src="/img?av=<?PHP echo(BUD_NAME);?>&pic=<?PHP echo($profilePic);?>" align="middle">  
   </div> 
    
    <input id="files" name="files[]" type="file" accept=".*" style="visibility: hidden;" multiple>
      
    <input type="hidden" id="a" name="a">    
    <input type="hidden" id="f" name="f">  
    
  </div>  

<div class="tools">
<div class="settingson" onclick="settingsOn();"></div>

  <?PHP if ($magicJar1 == 0): ?>
<div class="magicjar1" style="background:url(/res/magicjar1dis.png);" onclick="setJar1On()"></div>
<?PHP else: ?>
<div class="magicjar1" style="background:url(/res/magicjar1.png);" onclick="setJar1Off()"></div>
<?PHP endif; ?>

<?PHP if ($magicJar2 == 0): ?>
<div class="magicjar2" style="background:url(/res/magicjar2dis.png);" onclick="setJar2On()"></div>
<?PHP else: ?>
<div class="magicjar2" style="background:url(/res/magicjar2.png);" onclick="setJar2Off()"></div>
<?PHP endif; ?>

<?PHP if ($magicJar3 == 0): ?>
<div class="magicjar3" style="background:url(/res/magicjar3dis.png);" onclick="setJar3On()"></div>
<?PHP else: ?>
<div class="magicjar3" style="background:url(/res/magicjar3.png);" onclick="setJar3Off()"></div>
<?PHP endif; ?>

<div class="settingsoff" onclick="settingsOff();"></div>
</div>

<input type="hidden" id="txtMagicJar1" name="txtMagicJar1" value="<?PHP echo($magicJar1);?>">
<input type="hidden" id="txtMagicJar2" name="txtMagicJar2" value="<?PHP echo($magicJar2);?>">
<input type="hidden" id="txtMagicJar3" name="txtMagicJar3" value="<?PHP echo($magicJar3);?>">
    
 <input type="hidden" id="Password" name="Password" value="<?PHP echo($password);?>"> 
    
 </form>   
           
  <div id="footerCont">&nbsp;</div>
  <div id="footer"><span style="background:#FFFFFF; opacity:0.7;">&nbsp;&nbsp;<a class="aaa" href="dd.html">Disclaimer</a>.&nbsp;&nbsp;A <a href="http://numode.eu" class="aaa">NuMode</a> project and <a href="http://demo.numode.eu" class="aaa">WYSIWYG</a> system. <?PHP echo(getResource0("Some rights reserved", $lang));?></span></div>
           
<?PHP else: ?>          

  <body style="background:#FFFFFF no-repeat; background-size: cover; background-attachment: fixed; background-position: center;">

<?php if (file_exists(APP_PATH . DIRECTORY_SEPARATOR . "jscheck.html")): ?>
<?php include(APP_PATH . DIRECTORY_SEPARATOR . "jscheck.html"); ?> 
<?php endif; ?>

   <form id="frmUpload" role="form" method="post" action="/<?PHP echo(BUD_NAME);?>?hl=<?PHP echo($lang);?>" target="_self" enctype="multipart/form-data">  

   <div class="dragover" dropzone="copy"> 
   
   <br><br>
   
   <div id="title"> 
        <div style="min-width:550px;white-space: nowrap;">
            <div id="avatarLogo" onclick="$('#files').click()" style="float:left">
                <img id="picavatar" src="<?PHP echo($PROFILE_PIC);?>" align="middle" style="position:relative;display:inline;">
            </div>  
            <div id="avatarName" style="float:left">
              &nbsp;<?PHP echo(strtoupper($NICKNAME));?>&nbsp;&nbsp;&nbsp;
            </div>
        </div>  
        <div id="drop-img">
            <div id="fireupload" onclick="$('#files').click()">
              <img src="/res/dnd2.gif"><br>
            </div>
        </div>
        <div id="cudoz" style="display:none;">
        <?PHP for ($i=1;$i<=$CUDOZ;$i++): ?>
             <img id="cudozentry<?PHP echo($i);?>" class="cudoz-entry" src="/res/chicca_<?PHP echo($shortLang);?>.png">    
        <?PHP endfor; ?>
        <?PHP for ($i=$CUDOZ+1;$i<=5;$i++): ?>
             <img id="cudozentry<?PHP echo($i);?>" class="cudoz-entry" src="/res/chiccadis.png">    
        <?PHP endfor; ?>               
         </div> 
        <?PHP $CUDOZ++;  ?>
   </div> 
   
 <div id="blog">    
      <?PHP
   $pattern = $BLOG_PATH . DIRECTORY_SEPARATOR . "*.mp3";
   $aFilePaths = glob($pattern);   
   
   if (empty($aFilePaths)): ?>
            <div class="blog-content"> 
               <span class="blog-entry-nickname" style="color:#000000;">5 Mode:</span>            
              <div class="blog-entry">  
                <?PHP echo(getResource0("Hello from 5 Mode", $lang));?>,<br><br>
                <?PHP echo(getResource0("This is just an example of blog entry", $lang));?>.<br><br>
                <?PHP echo(getResource0("Drag-n-drop .mp3 files to shape the blog", $lang));?>.<br>
                <?PHP echo(getResource0("Drag-n-drop .png or .jpg files to shape the gallery", $lang));?>.<br>
                <?PHP echo(getResource0("The other files will land in the *magic pot*", $lang));?>.<br><br>
                <?PHP echo(getResource0("Attention: everyone who know the blog uri can partecipate or watch by loggin-in", $lang));?>.<br>
              </div> 
             </div>  
        <?PHP else: ?>
                <?PHP
      $CUDOZ++;          
      $iEntry = 1;
      $iCurEntry = 1;         
      //arsort($aFilePaths, SORT_STRING);
      //echo("blogSP=".$blogSP);
      foreach ($aFilePaths as $filePath) {
        //echo("iCurEntry=".$iCurEntry);
        if ($iCurEntry<($blogSP+1)) {
          $iCurEntry++;
          continue;
        }  
        if ($iEntry>APP_BLOG_MAX_POSTS) {
          break;
        }
        //$s=file_get_contents($filePath);
        //$fileName = basename($filePath);
        $orifilename = basename($filePath);
        $orifileExt = strtolower(pathinfo($orifilename, PATHINFO_EXTENSION));
        $fileName = explode("|",basename($filePath))[2];
        $aNameParts = explode("|",$orifilename);
        $myUserName = strtoupper($aNameParts[1]);
        if (isset($CONFIG['AUTH'][$myUserName]['NICKNAME'])) {            
           $myNickName = $CONFIG['AUTH'][$myUserName]['NICKNAME'];
           $myUserBGColor = $CONFIG['AUTH'][$myUserName]['COLOR'];
           $myUserColor = "red";
           $myAlign = "left";
           $myFontWeight = "900";
           if ($myUserName == USER_NAME) {
             $myNickName = $myNickName . " (". getResource0("YOU", $lang) .")";
             $myUserBGColor = "#FFFFFF";
             $myUserColor = "#000000";
             $myAlign ="right";
             $myFontWeight = "400";
           }
           
        } else {
           $myNickName = "Unknow (Attention!)";
           $myUserColor = "#000000";
        } 
          
        if ($iEntry === count($aFilePaths) || $iEntry==APP_BLOG_MAX_POSTS) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                          <div class="blog-content" style="margin-bottom:<?PHP echo($marginbottom);?>;text-align:<?PHP echo($myAlign);?>"> 
                          <span class="blog-entry-nickname" style="color:<?PHP echo($myUserColor); ?>;font-weight:<?PHP echo($myFontWeight);?>;"><?PHP echo($myNickName); ?>:</span>
                           <div class="blog-entry" style="width:100%;margin-bottom:0px;color:gray;background: <?PHP echo($myUserBGColor); ?>;text-align:<?PHP echo($myAlign);?>">  
                             <?PHP echo(getResource0("Play", $lang));?> "<?PHP echo(ucfirst($fileName));?>"<br><br>
                             <audio id="aplayer" controls preload="auto">
                                <source src="/audio?av=<?PHP echo(BUD_NAME);?>&file=<?PHP echo($orifilename);?>" type="audio/mpeg">
                             </audio>
                           </div> 
                          </div>   
                 <?PHP 
       $iEntry++;
       $iCurEntry++;          
      }?>
   <?PHP endif; ?>
   
   <?PHP
    $totPages = (int)(count($aFilePaths)/APP_BLOG_MAX_POSTS); 
    if ($totPages < (count($aFilePaths)/APP_BLOG_MAX_POSTS)) {
      $totPages++;
    }
    $firstPost = 0;
    $prevPost = $blogSP - APP_BLOG_MAX_POSTS;
    if ($prevPost < 0) {
      $prevPost = 0;
    }    
    $nextPost = $blogSP + APP_BLOG_MAX_POSTS;
    if ($nextPost > (($totPages - 1) * APP_BLOG_MAX_POSTS)) {
      $nextPost = (($totPages - 1) * APP_BLOG_MAX_POSTS);
    }
    if ($nextPost < 0) {
      $nextPost = 0;
    }       
    $lastPost = (($totPages - 1) * APP_BLOG_MAX_POSTS);
    if ($lastPost < 0) {
      $lastPost = 0;
    }    
   ?>
   
   <?PHP if (defined("APP_PAGINATION") && APP_PAGINATION): ?>
   
   <br><br>
   
   <div style="text-align:center;">
     <a href="/<?PHP echo(BUD_NAME); ?>/?blogSP=<?PHP echo($firstPost);?>"><img src="/res/first.png" style="width:45px;"></a>
     <a href="/<?PHP echo(BUD_NAME); ?>/?blogSP=<?PHP echo($prevPost);?>"><img src="/res/arrow-left2.png" style="width:45px;"></a>
     <a href="/<?PHP echo(BUD_NAME); ?>/?blogSP=<?PHP echo($nextPost);?>"><img src="/res/arrow-right2.png" style="width:45px;"></a>
     <a href="/<?PHP echo(BUD_NAME); ?>/?blogSP=<?PHP echo($lastPost);?>"><img src="/res/last.png" style="width:45px;"></a>
   </div>  
   
   <?PHP endif; ?>    
       
   <br><br>
          
   </div> 

 <div style="clear:both; margin:auto;">
    <br><br>
 </div>   

 <div id="gallery">    
   <div class="gallery-content"> 
     
      <?PHP
   $pattern = $GALLERY_PATH . DIRECTORY_SEPARATOR . "*";
   $aFilePaths = glob($pattern);
   if (empty($aFilePaths)): ?>
             
              <div class="image-entry">  
                  <div style="width:100%;border:0px solid black;"><img class="image-ico" src="/res/imgicon.png" align="center"></div>
                  <div style="margin-top:10px;"><?PHP echo(getResource0("Sample", $lang));?>.png</div>
              </div> 
             
        <?PHP else: ?>
                <?PHP
      $CUDOZ++;          
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $orifilename = basename($filePath);
        $filename = explode("|",basename($filePath))[2];
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                      <div class="image-entry">  
                        <a href="/img?av=<?PHP echo(BUD_NAME);?>&pic=<?PHP echo($orifilename);?>">
                        <div style="width:100%;border:0px solid black;"><img class="image-ico" src="/res/imgicon.png" align="center"></div>
                        <div style="margin-top:10px;"><?PHP echo($filename);?> </div>
                        </a>  
                      </div> 
                 <?PHP 
       $iEntry++;          
      }?>
        <?PHP endif; ?>
     
      </div>  
   </div> 

  <?PHP
   $pattern = $MAGICJAR1_PATH . DIRECTORY_SEPARATOR . "*";
   $aFilePaths = glob($pattern);
   
   if (empty($aFilePaths)): ?>

        <div id="magicjar1">    
             <div class="magicjar1-content">
                <div class="magicjar-num">&nbsp;1&nbsp;</div>
                   <div class="file-entry">                  
                      <div style="width:100%;border:0px solid black;"><img class="image-ico" src="/res/fileicon.png" align="center"></div>
                      <div style="margin-top:10px;"><?PHP echo(getResource0("Sample", $lang));?>.doc</div>
                   </div> 
            </div> 
       </div>             
       
<?PHP else: ?>
  
        <div id="magicjar1">    
             <div class="magicjar1-content"> 
     
               <div class="magicjar-num">&nbsp;1&nbsp;</div>
               
                <?PHP
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $orifilename = basename($filePath);
        $orifileExt = strtolower(pathinfo($orifilename, PATHINFO_EXTENSION));
        $filename = explode("|",basename($filePath))[2];
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                      <div class="file-entry">  
                        <?PHP if (in_array($orifileExt, ["png", "jpg", "jpeg", "gif", "webp"])):?>                   
                        <a href="/imgj?av=<?PHP echo(BUD_NAME);?>&jar=1&fn=<?PHP echo($orifilename);?>">
                        <?PHP else: ?>  
                        <a href="/file?av=<?PHP echo(BUD_NAME);?>&jar=1&fn=<?PHP echo($orifilename);?>">
                        <?PHP endif; ?>  
                        <div style="width:100%;border:0px solid black;"><img class="file-ico" src="/res/fileicon.png" align="center"></div>
                        <div style="margin-top:10px;"><?PHP echo($filename);?> </div>
                        </a>  
                      </div> 
                 <?PHP 
       $iEntry++;          
      }?>
             </div>  
        </div> 
    
       <?PHP endif; ?>

  <?PHP
   $pattern = $MAGICJAR2_PATH . DIRECTORY_SEPARATOR . "*";
   $aFilePaths = glob($pattern);
   
   if (!empty($aFilePaths)): ?>
  
        <div id="magicjar2">    
             <div class="magicjar2-content"> 
     
               <div class="magicjar-num">&nbsp;2&nbsp;</div>
               
                <?PHP
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $orifilename = basename($filePath);
        $orifileExt = strtolower(pathinfo($orifilename, PATHINFO_EXTENSION));
        $filename = explode("|",basename($filePath))[1];
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                      <div class="file-entry">  
                        <?PHP if (in_array($orifileExt, ["png", "jpg", "jpeg", "gif", "webp"])):?>                   
                            <a href="/imgj?av=<?PHP echo(BUD_NAME);?>&jar=2&fn=<?PHP echo($orifilename);?>">
                        <?PHP else: ?>  
                            <a href="/file?av=<?PHP echo(BUD_NAME);?>&jar=2&fn=<?PHP echo($orifilename);?>">
                        <?PHP endif; ?> 
                       <div style="width:100%;border:0px solid black;"><img class="file-ico" src="/res/fileicon.png" align="center"></div>
                        <div style="margin-top:10px;"><?PHP echo($filename);?> </div>
                        </a>  
                      </div> 
                 <?PHP 
       $iEntry++;          
      }?>
             </div>  
        </div> 
    
       <?PHP endif; ?>

  <?PHP
   $pattern = $MAGICJAR3_PATH . DIRECTORY_SEPARATOR . "*";
   $aFilePaths = glob($pattern);
   
   if (!empty($aFilePaths)): ?>
  
        <div id="magicjar3">    
             <div class="magicjar3-content"> 
     
               <div class="magicjar-num">&nbsp;3&nbsp;</div>
               
                <?PHP
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $orifilename = basename($filePath);
        $orifileExt = strtolower(pathinfo($orifilename, PATHINFO_EXTENSION));
        $filename = explode("|",basename($filePath))[1];
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                      <div class="file-entry">  
                       <?PHP if (in_array($orifileExt, ["png", "jpg", "jpeg", "gif", "webp"])):?>                   
                          <a href="/imgj?av=<?PHP echo(BUD_NAME);?>&jar=3&fn=<?PHP echo($orifilename);?>">
                       <?PHP else: ?>  
                          <a href="/file?av=<?PHP echo(BUD_NAME);?>&jar=3&fn=<?PHP echo($orifilename);?>">
                       <?PHP endif; ?> 
                        <div style="width:100%;border:0px solid black;"><img class="file-ico" src="/res/fileicon.png" align="center"></div>
                        <div style="margin-top:10px;"><?PHP echo($filename);?> </div>
                        </a>  
                      </div> 
                 <?PHP 
       $iEntry++;          
      }?>
             </div>  
        </div> 
    
       <?PHP endif; ?>
    
 <div id="friends">    
   <div class="friends-content"> 
     
      <div id="mynetworkTitle"><?PHP echo(getResource0("My Network", $lang));?>:<br><br>
     
      <?PHP
   $pattern = $FRIENDS_PATH . DIRECTORY_SEPARATOR . "*.txt";
   $aFilePaths = glob($pattern);
   if (empty($aFilePaths)): ?>
             
              <div class="friend-entry">  
                   <a href="http://5mode.com"> 
                   <div style="width:100%;border:0px solid black;"><img class="friend-ico" src="/res/pic1.png" align="center"></div>
                   <div style="margin-top:10px;"><?PHP echo(getResource0("5 Mode", $lang));?></div>
                   </a>
              </div> 
             
        <?PHP else: ?>
                <?PHP
      $CUDOZ++;  
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $orifilename = basename($filePath);
        $link=file_get_contents($filePath);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                      <div class="friend-entry">  
                        <a href="<?PHP echo($link);?>">
                        <div style="width:100%;border:0px solid black;"><img class="friend-ico" src="/res/pic1.png" align="center"></div>
                        <div style="margin-top:10px;"><?PHP echo($filename);?> </div>
                        </a>  
                      </div> 
                 <?PHP 
       $iEntry++;          
      }?>
        <?PHP endif; ?>
     
          </div>  
          
      </div>  
   </div> 
    
<!--    
  <div id="passworddisplay">
       <br>  
        &nbsp;&nbsp;<input type="password" id="Password" name="Password" placeholder="password" value="<?php echo($password);?>" autocomplete="off">&nbsp;<input type="submit" value="<?PHP echo(getResource0("Go", $lang));?>" style="text-align:left;width:25%;color:#000000;"><br>
        &nbsp;&nbsp;<input type="text" id="Salt" placeholder="salt" autocomplete="off"><br>
        <div style="text-align:center;">
           <a id="hashMe" href="#" onclick="showEncodedPassword();"><?PHP echo(getResource0("Hash Me", $lang));?>!</a>
        </div>
 </div> 
-->

    <input id="files" name="files[]" type="file" accept=".*" style="visibility: hidden;" multiple>
      
    <input type="hidden" id="a" name="a">    
    <input type="hidden" id="f" name="f">  

    <input type="hidden" id="password" name="password" value="<?PHP echo($password);?>">     
            
  </div>  

 </form>       
 
  <div id="footerCont" style="position:relative;">&nbsp;</div>
  <div id="footer" style="position:relative;;">
    <div style="float:left">
        <select id="cbLang" onchange="changeLang(this);">
          <option value="en-US" <?PHP echo(($lang==PHP_EN?"selected":""));?>>en</option>
          <option value="it-IT" <?PHP echo(($lang==PHP_IT?"selected":""));?>>it</option>
          <option value="zh-CN" <?PHP echo(($lang==PHP_CN?"selected":""));?>>cn</option>
        </select> 
    </div>
    <span style="background:#FFFFFF; opacity:0.7;">&nbsp;&nbsp;A <a href="http://numode.eu" class="aaa">NuMode</a> project and <a href="http://demo.numode.eu" class="aaa">WYSIWYG</a> system. CC</span></div>
           
 <?PHP endif; ?>           
     
<script src="/static/js/home-js.php?hl=<?PHP echo($lang);?>&av=<?PHP echo(BUD_NAME);?>&cv=<?PHP echo($CURRENT_VIEW);?>&cu=<?PHP echo($CUDOZ);?>" type="text/javascript"></script>

<?PHP if ($CURRENT_VIEW == PUBLIC_VIEW): ?>  

<!-- SKINNER CODE -->
<?php if (is_readable($BUD_PATH . DIRECTORY_SEPARATOR . "skinner.html")): ?>
<?php include($BUD_PATH . DIRECTORY_SEPARATOR . "skinner.html"); ?> 
<?php else: ?>
      <?php if (file_exists(APP_PATH . DIRECTORY_SEPARATOR . "skinner.html")): ?>
      <?php include(APP_PATH . DIRECTORY_SEPARATOR . "skinner.html"); ?> 
      <?php endif; ?>
<?php endif; ?>

<!-- METRICS CODE -->
<?php if (file_exists(APP_PATH . DIRECTORY_SEPARATOR . "metrics.html")): ?>
<?php include(APP_PATH . DIRECTORY_SEPARATOR . "metrics.html"); ?> 
<?php endif; ?>

<?php endif; ?>

</body>
</html>
