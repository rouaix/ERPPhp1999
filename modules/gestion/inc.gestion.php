<?php
if (file_exists("securite.php")){include("securite.php");}

    switch (@$_SESSION["inc"]) {
      default :
        if(file_exists("scripts/page.construction.php")){include("scripts/page.construction.php");}
      break;  
      case "**depense":
        if(utilisateur()){
          if (file_exists("scripts/inc.gestion.depense.php")){include("scripts/inc.gestion.depense.php");}
        }  
      break;
    }

unset($_SESSION["inc"]);
?>