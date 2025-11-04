<?php

/**
 * Copyright (c) 2016, 2024, 5 Mode
 * 
 * This file is part of FoatingBuds.
 * 
 * FoatingBuds is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * FoatingBuds is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.  
 * 
 * You should have received a copy of the GNU General Public License
 * along with FoatingBuds. If not, see <https://www.gnu.org/licenses/>.
 *
 * index.php
 * 
 * FoatingBuds index file.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode     
 */

require "../Private/core/init.inc";


// FUNCTION AND VARIABLE DECLARATIONS
$scriptPath = APP_SCRIPT_PATH;

// PARAMETERS VALIDATION

$url = filter_input(INPUT_GET, "url")??"";
$url = strip_tags($url);
$url = strtolower(trim(substr($url, 0, 300), "/"));

switch ($url) {
  case "action":
    $scriptPath = APP_AJAX_PATH;
    define("SCRIPT_NAME", "action");
    define("SCRIPT_FILENAME", "action.php");     
    break;
  case "":
  case "home":   
  
    if (defined("APP_HOME_PATH") && (APP_HOME_PATH !== PHP_STR) && is_readable(APP_HOME_PATH)) {
      define("SCRIPT_NAME", "homeproxy");
      define("SCRIPT_FILENAME", "homeproxy.php");   
    } else {
    
  #    define("SCRIPT_NAME", "home");
  #   define("SCRIPT_FILENAME", "home.php");   
  #   
  #    $pattern = APP_DATA_PATH . DIRECTORY_SEPARATOR . "*";
  #   $aAvatarPaths = glob($pattern, GLOB_ONLYDIR);
  #    if (empty($aAvatarPaths)) {
  #     die("<br>&nbsp;No chat exists yet: type in the url with your chat uri like http://" . $_SERVER['HTTP_HOST']. "/&lt;your chat&gt;.<br>&nbsp;");
  #    } else {
  #      define("BUD_NAME", basename($aAvatarPaths[0]));
  #    }
  
      die("<br>&nbsp;You have to define an homepage.<br>&nbsp;");
  
    }
    
    break;
  case "doc":
    $avatar = filter_input(INPUT_GET, "av")??"";
    $avatar = strip_tags($avatar);
        
    $BUD_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    
    $repo = filter_input(INPUT_GET, "re")??"";
    $repo = strip_tags($repo);
    switch ($repo) {
      case "cv":
        $REPO_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "cv";     
        break;
      default:
        die("unknown parma value:".$repo);
    }
    
    $doc = filter_input(INPUT_GET, "doc")??"";
    $doc = strip_tags($doc);
       
    $originalFilename = pathinfo($doc, PATHINFO_FILENAME);
    $destFilename = explode("|",$originalFilename)[1];
    $originalFileExt = pathinfo($doc, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
    
    $docPath = $REPO_PATH . DIRECTORY_SEPARATOR . $doc;
       
    if (filesize($docPath) <= APP_FILE_MAX_SIZE) { 
      switch ($fileExt) {
        case "doc":
          header("Content-Type: application/msword");
          header('Content-Disposition: attachment; filename=' . $destFilename . '.doc');
          break;
        case "pdf":
          header("Content-Type: application/pdf");
          header('Content-Disposition: attachment; filename=' . $destFilename . '.pdf');
          break;
        default:
          die("unknown file extension.");
      }
      echo(file_get_contents($docPath));
      exit(0);
    } else {
      die("doc size over app limits.");
    }  
    
    break;
  case "audio":
    $avatar = filter_input(INPUT_GET, "av")??"";
    $avatar = strip_tags($avatar);    
    
    $BUD_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    $AUDIO_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "blog";     

    $file = filter_input(INPUT_GET, "file")??"";
    $file = strip_tags($file);
       
    $originalFilename = pathinfo($file, PATHINFO_FILENAME);
    $originalFileExt = pathinfo($file, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
    $filePath = $AUDIO_PATH . DIRECTORY_SEPARATOR . $file;
       
    if (filesize($filePath) <= APP_FILE_MAX_SIZE) { 
      if ($fileExt === "mp3") {
        header("Content-Type: audio/mpeg");
      } else {
        header("Content-Type: audio/" . $fileExt);
      }  
      echo(file_get_contents($filePath));
      exit(0);
    } else {
      die("audio size over app limits.");
    }  
    
    break;

  case "img":
    $avatar = filter_input(INPUT_GET, "av")??"";
    $avatar = strip_tags($avatar);    
    
    $BUD_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    $GALLERY_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "gallery";     

    $pic = filter_input(INPUT_GET, "pic")??"";
    $pic = strip_tags($pic);
       
    $originalFilename = pathinfo($pic, PATHINFO_FILENAME);
    $originalFileExt = pathinfo($pic, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($pic, PATHINFO_EXTENSION));
    
    if ($pic === APP_DEF_PROFILE_PIC) {
      $picPath = APP_PATH . DIRECTORY_SEPARATOR . "static" . $pic;
    } else {
      $picPath = $GALLERY_PATH . DIRECTORY_SEPARATOR . $pic;
    }  
       
    if (filesize($picPath) <= APP_FILE_MAX_SIZE) { 
      if ($fileExt === "jpg") {
        header("Content-Type: image/jpeg");
      } else {
        header("Content-Type: image/" . $fileExt);
      }  
      echo(file_get_contents($picPath));
      exit(0);
    } else {
      die("picture size over app limits.");
    }  
    
    break;
  case "imgj":
    $avatar = filter_input(INPUT_GET, "av")??"";
    $avatar = strip_tags($avatar);
    $jar = (int)substr(strip_tags(filter_input(INPUT_GET, "jar")??""),0,1);
    if ($jar >= 1 && $jar <= 3) {
    } else {
      die("jar parameter error.");
    }
    
    $BUD_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    $JAR_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "magicjar" . $jar;     

    $fileName = filter_input(INPUT_GET, "fn")??"";
    $fileName = strip_tags($fileName);
       
    $originalFilename = pathinfo($fileName, PATHINFO_FILENAME);
    $orioriFilename = explode("|", $originalFilename)[1];
    $originalFileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    $filePath = $JAR_PATH . DIRECTORY_SEPARATOR . $fileName;
       
    if (filesize($filePath) <= APP_FILE_MAX_SIZE) { 
      if ($fileExt === "jpg") {
        header("Content-Type: image/jpeg");
      } else {
        header("Content-Type: image/" . $fileExt);
      }  
      //header("Content-Disposition: attachment; filename=" . $orioriFilename . ".$fileExt");
      echo(file_get_contents($filePath));
      exit(0);
    } else {
      die("file size over app limits.");
    }  
    
    break;    
  case "file":
    $avatar = filter_input(INPUT_GET, "av")??"";
    $avatar = strip_tags($avatar);
    $jar = (int)substr(strip_tags(filter_input(INPUT_GET, "jar")??""),0,1);
    if ($jar >= 1 && $jar <= 3) {
    } else {
      die("jar parameter error.");
    }
    
    $BUD_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    $JAR_PATH = $BUD_PATH . DIRECTORY_SEPARATOR . "magicjar" . $jar;     

    $fileName = filter_input(INPUT_GET, "fn")??"";
    $fileName = strip_tags($fileName);    
    
    $originalFilename = pathinfo($fileName, PATHINFO_FILENAME);
    $orioriFilename = explode("|", $originalFilename)[1];
    $originalFileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    $filePath = $JAR_PATH . DIRECTORY_SEPARATOR . $fileName;
       
    if (filesize($filePath) <= APP_FILE_MAX_SIZE) { 
      header("Content-Type: avatarfree/bin");
      header("Content-Disposition: attachment; filename=" . $orioriFilename . ".$fileExt");
      echo(file_get_contents($filePath));
      exit(0);
    } else {
      die("file size over app limits.");
    }  
    
    break;    
  default:
    define("SCRIPT_NAME", "home");
    define("SCRIPT_FILENAME", "home.php");   

    define("BUD_NAME", $url);

    break;
}

if (SCRIPT_NAME==="err-404") {
  header("HTTP/1.1 404 Not Found");
}  

require $scriptPath . "/" . SCRIPT_FILENAME;
