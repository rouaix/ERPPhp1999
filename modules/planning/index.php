<?php
//if(file_exists("../../securite.php")){include("../../securite.php");}
echo "<div style=\"color:#".@$_SESSION["modules"]["couleurtexte"][$_SESSION["page"]].";background-color:#".@$_SESSION["modules"]["couleurfond"][$_SESSION["page"]].";\">";
if(file_exists("scripts/modules/planning/inc.planning.php")){
  include("scripts/modules/planning/inc.planning.php");
}else{erreur_404("Agenda Fonctions");}
echo "</div>";
?>