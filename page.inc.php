<?php 
if(!isset($_SESSION)){session_start();}
//if (file_exists("securite.php")){include("securite.php");}

if (file_exists("inc.config.php")){include("inc.config.php");}
//if(file_exists("scripts/inc.config.php")){include("scripts/inc.config.php");}

if(count($_GET)){
   while (list($key, $val) = each($_GET)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

if(count($_POST)){
   while (list($key, $val) = each($_POST)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

if(utilisateur()){
  if(file_exists($_SESSION["inclure"].".php")){include($_SESSION["inclure"].".php");}
}

//if (file_exists("scripts/".$_SESSION["inclure"].".php")){include("scripts/".$_SESSION["inclure"].".php");}

unset($_GET);
unset($_POST);
unset($_SESSION["inclure"]);
//unset($_SESSION["vid"]);
?>
