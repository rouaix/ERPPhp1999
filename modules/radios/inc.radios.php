<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}
if(file_exists("inc.config.php")){include("inc.config.php");}else{$_SESSION["alerte"]="inc.config.php";}
//if(file_exists("scripts/inc.config.php")){include("scripts/inc.config.php");}else{$_SESSION["alerte"]="scripts/inc.config.php";}
?> <img class="pop" id="fermer" src="images/jpg/x.jpg" title="Fermer" onclick="javascript:voir('leformulaire');"> <?php
echo "<h3 onclick=\"javascript:voir('leformulaire')\" title=\"Fermer\" id=\"lien\">Radios disponibles</h3>";  
echo "<select class=\"radios\" onchange=\"javascript:radio(this.value);voir('leformulaire');\">";
$sql = "select * from radio order by radio";
$result = mysql_query($sql);
while ($ligne = mysql_fetch_array($result)){
  echo "<option class=\"radios\" value=\"".$_SESSION["location"]."scripts/radios.php?radio=".$ligne["id"]."&titre=".$ligne["radio"]."\">";

  echo $ligne["radio"]."</option>";      
} 
echo "</select>";
echo "<br><img src=\"images/png/casque.png\" style=\"height:32px;vertical-align:middle;margin:5px;\">";
echo "<div class=\"content-separator\">&nbsp;</div>";
//echo "<ul class=\"nice-list\">";
//$sql = "select * from radio order by radio";
//$result = mysql_query($sql);
//while ($ligne = mysql_fetch_array($result)){
  //echo "<li id=\"lien\" title=\"Ecouter\" onclick=\"javascript:window.open('scripts/radio.php?radio=".$ligne["id"]."&titre=".$ligne["radio"]."','window','width=300,height=190');voir('leformulaire');\">";
  //echo "<img src=\"".$ligne["lien"]."\" height=\"16px\" hspace=\"5\" vspace=\"1\" border=\"0\">";
  //echo "&nbsp;<img src=\"images/png/casque.png\" height=\"12px\" border=\"0\">&nbsp;&nbsp;";
  //echo "".$ligne["radio"]."</li>";      
//}         
//echo "</ul>";         
?>