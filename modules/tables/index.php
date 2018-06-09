<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

$droits = cherche_droits();
while (list(,$val) = @each($droits)){
  if($val["type_droits"] == "table" && $val["valeur_droits"] == 0){$liste_droits_tables[$val["id_droits"]] = $val;}
  if($val["type_droits"] == "table" && $val["nom_droits"] == "droits" && $val["id_droits"] != 0){$droits_tables[$val["id_droits"]] = $val;}  
  
  if($val["type_droits"] == "champs" && $val["valeur_droits"] == 0){$liste_droits_champs[$val["id_droits"]] = $val;}  
  if($val["type_droits"] == "champs" && $val["nom_droits"] == "droits" && $val["id_droits"] != 0){$droits_champs[$val["id_droits"]] = $val;}
}
//unset($droits);

switch (@$_SESSION["montre"]) {
  default :
    echo "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?montre=listedestables\"><img src=\"".$_SESSION["ico"]["voir"]."\" class=\"module\"><b>Liste des tables</b></a></div>\n";
    echo "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?montre=droitsdestables\"><img src=\"".$_SESSION["ico"]["voir"]."\" class=\"module\"><b>Droits des tables</b></a></div>\n";
    echo "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?montre=cartedestables\"><img src=\"".$_SESSION["ico"]["orange"]."\" class=\"module\"><b>Cr&eacute;ation de la carte des tables</b></a></div>\n";
  break;
  case "droitsdeschamps" :
    if(file_exists("scripts/modules/tables/champs.droits.php")){include("scripts/modules/tables/champs.droits.php");}
  break;
  case "droitsdestables" :
    if(file_exists("scripts/modules/tables/tables.droits.php")){include("scripts/modules/tables/tables.droits.php");}
  break;
  case "cartedestables" :
    if(file_exists("scripts/modules/tables/tables.carte.php")){include("scripts/modules/tables/tables.carte.php");}
  break;
  case "listedestables" :
    if(file_exists("scripts/modules/tables/tables.liste.php")){include("scripts/modules/tables/tables.liste.php");}
   break;
   case "contenutable" :
    if(file_exists("scripts/modules/tables/tables.contenu.php")){include("scripts/modules/tables/tables.contenu.php");}
  break;
}

function cherche_droits(){
  $x = "";
  $result = @mysql_query("select * from droits order by nom_droits asc")or die("erreur Droits !");
  while ($ligne = mysql_fetch_array($result)){
    $x[$ligne["id_droits"]] = $ligne;
  }
  return $x;
}

function lien_editer($val){
  $temp = "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".@$_SESSION["table"]."&acte=formulaire&formulaire=modifier&modifier=".$val[0]."','surpopup');loadobjs();\"><b>".$val[1]."</b>&nbsp;</a>";
  return $temp;
}

function verif_droit_champs($droits,$champs,$table,$droits_champs){
  $ok = 0;
  while (list(, $test) = @each($droits_champs)){
    if($test["id_droits"] == $champs && $test["valeur_droits"] == $droits && $test["nom_table"] == $table && $test["type_droits"] == "droits"){
      $ok = $test;
    }
  }
  return $ok;
}

function verif_droit_table($droits,$table,$droits_table){
  $ok = 0;
  while (list(, $test) = @each($droits_table)){
    if($test["nom_droits"] == $table && $test["valeur_droits"] == $droits && $test["type_droits"] == "droits"){
      $ok = $test;
    }
  }
  return $ok;
}
?>