<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
//module_titre($_SESSION["page"],'');
echo "<div class=\"module\" id=\"titre\">Liste des Radios disponibles";
echo " <i>(";
echo "<a href=\"http://www.interoperabilitybridges.com/ChromeWMP/wmpChrome.crx\" target=\"Plugin\" title=\"Charger le plugin Windows pour Chrome, Firefox, Safari.\">Charger le plugin Windows pour Chrome, Firefox, Safari.</a>";
echo ")</i>";
echo "</div>\n";

echo "<table width=\"100%\">\n";
$sql = "select * from radios where etat_radios ='' order by nom_radios asc";
$result = mysql_query($sql);
while ($ligne = mysql_fetch_array($result)){
  echo "<tr>\n";
  if(isset($_SESSION["userid"]) && utilisateur($_SESSION["userid"])){
    echo "<td width=\"45px\" id=\"milieu\">";
    echo ico_hs($ligne,$_SESSION["page"]);
    echo "</td>\n";
  }  
  echo "<td>";
    echo "<div class=\"module\" id=\"ligne\" title=\"Ecouter\" style=\"cursor:pointer;\" onclick=\"javascript:radio('../scripts/modules/radios/radios.php?radio=".$ligne["id_radios"]."&titre=".$ligne["nom_radios"]."&lienradio=".$ligne["lien_radios"]."');\">";        
    echo "<img src=\"".$_SESSION["ico"]["radio"]."\" id=\"i32\" style=\"margin-right:5px;\">";
    if(isset($ligne["etat_".$_SESSION["page"]]) && $ligne["etat_".$_SESSION["page"]]=="hs"){echo "<s>";}
    echo $ligne["nom_radios"];
    echo " <i>(".$ligne["lien_radios"].")</i>";
    if(isset($ligne["etat_".$_SESSION["page"]]) && $ligne["etat_".$_SESSION["page"]]=="hs"){echo "<s>";}
    echo "</div>\n";  
  echo "</td>\n";
  echo "</tr>\n";  
}
echo "</table>\n";

?>