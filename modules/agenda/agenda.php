<?php
//if (file_exists("securite.php")){include("securite.php");}

//if(isset($_SESSION["vue"])){
  //$ok = array("liste","jour","semaine","mois","an");
  //if(!in_array($_SESSION["vue"],$ok)){$_SESSION["vue"]="jour";} 
//}else{
  //$_SESSION["vue"]="jour";
//}

echo "<div class=\"module\" id=\"titre\">";
if($_SESSION["jour"] != mktime(0, 0, 0, date("m"), date("d"), date("Y"))){
  echo "<a href=\"".$_SESSION["lien"]."?page=agenda&jour=".mktime(0, 0, 0, date("m"), date("d"), date("Y"))."\" title=\"Retour à aujourd'hui\"><img src=\"".$_SESSION["ico"]["gauche"]."\" class=\"module\"></a>";
}
echo date_texte($_SESSION["jour"])." - Semaine ".date("W",$_SESSION["jour"]);
if($_SESSION["vue"] != "mois" && $_SESSION["vue"] != "an" && $_SESSION["vue"] != "liste"){
  if(@$_SESSION["tout"]== "o"){
    echo "&nbsp;<a title=\"Affichage Standard\" href=\"".$_SESSION["lien"]."?tout=n\"><img src=\"".$_SESSION["ico"]["bas"]."\" class=\"module\"></a>";
  }else{
    echo "&nbsp;<a title=\"Tout Afficher\" href=\"".$_SESSION["lien"]."?tout=o\"><img src=\"".$_SESSION["ico"]["haut"]."\" class=\"module\"></a>";
  }
}
echo "</div>";

if(file_exists("scripts/modules/agenda/vue.".$_SESSION["vue"].".php")){
  include("scripts/modules/agenda/vue.".$_SESSION["vue"].".php");
}else{page_en_construction();}

unset($liste_agenda);
unset($code);
unset($page);

unset($_SESSION["lundi"]);
unset($_SESSION["mardi"]);
unset($_SESSION["mercredi"]);
unset($_SESSION["jeudi"]);
unset($_SESSION["vendredi"]);
unset($_SESSION["samedi"]);
unset($_SESSION["dimanche"]);
unset($_SESSION["semaine"]);


unset($_SESSION["inclure"]);
unset($_SESSION["categorie"]);
unset($_SESSION["preference"]);
unset($_SESSION["total"]); 
?>