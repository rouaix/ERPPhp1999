<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
$ico = module_icone("erreurs");

echo "<div class=\"module\" id=\"\">";
  echo "<b>Liste des erreurs en attente de correction</b>";
echo "</div>\n";

$result = mysql_query("select * from erreurs order by etat_erreurs,nom_erreurs asc")or die("erreur erreurs !");
while ($ligne = mysql_fetch_array($result)) {

  echo "<div class=\"module\" id=\"hover\">";
    //if(isset($ico)){echo "<img class=\"module\" title=\"\" src=\"".$ico."\">";}
    
    echo ico_supprimer($ligne,"erreurs");
    //echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?table=erreurs&action=effaceligne&effaceligne=".$ligne["id_erreurs"]."\" title=\"Supprimer !\">";
    //echo "<img class=\"module\" src=\"".$_SESSION["ico"]["supprimer"]."\">";
    //echo "</a>";

    echo "<img class=\"module\" src=\"".$_SESSION["ico"]["voir"]."\" title=\"Afficher !\" onclick=\"javascript:voir('pa".$ligne["id_erreurs"]."');\">";

    echo ico_termine($ligne,"erreurs");

    
    echo "<a class=\"module\" title=\"Modifier !\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=erreurs&acte=formulaire&formulaire=modifier&modifier=".$ligne["id_erreurs"]."','surpopup');loadobjs();\">";
    echo "&nbsp;";
    if($ligne["etat_erreurs"]=="t"){echo "<s>";}
    echo "<b>".$ligne["nom_erreurs"]."</b>";
    echo "</a>\n";
    
    echo "<div class=\"module\" id=\"pa".$ligne["id_erreurs"]."\" style=\"display:none;\">";
    echo "<p>".nl2br($ligne["info_erreurs"])."<p id=\"droite\"><i>".$ligne["horloge_erreurs"]."</i>";
    echo "</div>\n";
    if($ligne["etat_erreurs"]=="t"){echo "</s>";}
  echo "</div>\n";


}
    
?>