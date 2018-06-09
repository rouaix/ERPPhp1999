<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}

    switch (@$_SESSION["inc"]) {
      default :
        if(file_exists("scripts/page.erreur.php")){include("scripts/page.erreur.php");}
      break;  
      case "secour":
        if (file_exists("scripts/inc.user.secour.php")){include("scripts/inc.user.secour.php");}
      break;
      case "info":
        if(utilisateur($_SESSION["userid"])){
          if (file_exists("scripts/inc.user.info.php")){include("scripts/inc.user.info.php");}
        }  
      break;
    }

unset($_SESSION["inc"]);
?>