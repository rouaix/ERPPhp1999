<?php
if (file_exists("securite.php")){include("securite.php");}
//cherche_categorie();
switch (@$_SESSION["voir"]) {
  default :
    if (file_exists("scripts/inc.".$_SESSION["page"].".".$_SESSION["voir"].".php")){
      //include("scripts/inc.".$_SESSION["page"].".".$_SESSION["inc"].".php");
      if(file_exists("scripts/page.construction.php")){include("scripts/page.construction.php");}
    }else{
      if(file_exists("scripts/page.construction.php")){include("scripts/page.construction.php");}
    }          
  break;
  
  case "preference":
    //if (file_exists("scripts/inc.organiseur.preference.agenda.php")){include("scripts/inc.organiseur.preference.agenda.php");}
    //if (file_exists("scripts/inc.organiseur.preference.categorie.php")){include("scripts/inc.organiseur.preference.categorie.php");}
  break;
}
?>