<?php
//if(file_exists("../../securite.php")){include("../../securite.php");}

if(file_exists("scripts/modules/agenda/fonctions.php")){
  include("scripts/modules/agenda/fonctions.php");
}else{erreur_404("Agenda Fonctions");}

if(!isset($_SESSION["jour"]) or @$_SESSION["jour"] == ""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
if(!isset($_SESSION["semaine"]) or @$_SESSION["semaine"] == ""){$_SESSION["semaine"] = semaine_numero("");}

$xjour = mktime(0, 0, 0, date("m",$_SESSION["jour"]),date("d",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));

//cherche_heure_travail();
cherche_preferences_horaire_travail();
$liste = cherche_evenement();


echo "<table width=\"100%\">";
echo "<tr>";
echo "<td>";
if(file_exists("scripts/modules/agenda/agenda.php")){include("scripts/modules/agenda/agenda.php");}
echo "</td>";
echo "<td width=\"200px\">";
if(file_exists("scripts/modules/agenda/calendrier.php")){include("scripts/modules/agenda/calendrier.php");}

if($_SESSION["vue"]=="jour"){
  echo "<div class=\"module\" id=\"titre\">";
  echo "Acitivt&eacute; du jour = ".compte_temps_jour(@$xjour);
  echo "</div>";
  $liste = cherche_evenement();
  compte_evenement_jour($liste,$_SESSION["jour"]);
  echo "<div class=\"module\" id=\"titre\">";
  echo "Evenements du jour = ".$_SESSION["total"]["evenement"][strtolower(jour_texte($_SESSION["jour"]))];
  echo "</div>";
}

echo "</td>";
echo "</tr>";
echo "</table>";

unset($liste);
unset($_SESSION["total"]);
?>