<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

echo "<div class=\"module\" id=\"titre\">Actualit&eacute; du site</div>\n";
if($result = mysql_query("select * from nouvelle where etat !='t' and archive= '' order by id DESC")){
  echo "<ul>\n";
  while ($ligne = @mysql_fetch_array($result)){
    echo "<li".categorie($ligne,"t").">";
      if($ligne["nom"]!=""){echo "<p><b>".$ligne["nom"]."</b>";}
      if($ligne["contenu"]!=""){echo "<br><i>".$ligne["contenu"]."</i>";}
      if($ligne["horloge"]!=""){echo "<br><i>".$ligne["horloge"]."</i>";}
    echo "</li>\n";
  }
  echo "</ul>\n";
}
?>