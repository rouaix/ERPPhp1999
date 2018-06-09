<?php
if (file_exists("securite.php")){include("securite.php");}

$_SESSION["ico"]["droite"] = "images/png/fd.png";
$_SESSION["ico"]["gauche"] = "images/png/fg.png";
$_SESSION["ico"]["haut"] = "images/png/fh.png";
$_SESSION["ico"]["bas"] = "images/png/fb.png";

if(!isset($_SESSION["voir"]) or @$_SESSION["voir"] == ""){$_SESSION["voir"] = "tables";}
if(!isset($_SESSION["table"]) or @$_SESSION["table"] == ""){$_SESSION["table"] = "tables";}
$format = array("png","pdf","txt","jpg");

if (administrateur($_SESSION["userid"])){

$mime = array();
$dir = "images/mime/";
if ($handle = opendir($dir)) {
  while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "index.php"){
      $ext = pathinfo($file, PATHINFO_FILENAME);
      array_push($mime, $ext);
    }
  }
}

liste_session($_SESSION);

}else{
  echo "<h2>";
  echo "Vous n'avez pas d'autorisation !";
  echo "</h2>\n";
}

function liste_session($x){
  while (list($k, $v) = each($x)){
    if(!is_array($k)){
      echo "<div style=\"margin-left:20px;\">";
      echo $k." = ";
      if(!is_array($v)){
        echo $v." (".sizeofvar( $v ).")";
      }else{
        liste_session($v);
      }
      echo "</div>";
    }else{
      liste_session($k);
    }
  }
}


// convertion d'un nombre d'octet en kB, MB, GB
function convert_SIZE($size)
{
    $unite = array('B','KB','MB','GB');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unite[$i];
}

//affiche l'empreinte mémoire  d'une variable
function sizeofvar($var)
{
  $start_memory = memory_get_usage();
  $temp =unserialize(serialize($var ));
  $taille = memory_get_usage() - $start_memory;
  return convert_SIZE($taille) ;
}

//affiche des info sur l'espace mémoire du script PHP
function memory_stat()
{
   echo  '<b>M&eacute;moire</b><br> Utilis&eacute; : '. convert_SIZE(memory_get_usage(false)) .
   '<br>Allou&eacute; : '.
   convert_SIZE(memory_get_usage(true)) .
   '<br>Max Utilis&eacute;  : '.
   convert_SIZE(memory_get_peak_usage(false)).
   '<br>Max Allou&eacute;  : '.
   convert_SIZE(memory_get_peak_usage(true)).
   '<br>Max autoris&eacute; : '.
   ini_get('memory_limit') ;
}
?>
