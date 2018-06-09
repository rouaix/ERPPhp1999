<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

echo "<div class=\"module\" id=\"titre\">Actualit&eacute; du site</div>\n";
if($result = mysql_query("select * from nouvelle where etat_nouvelle !='t' order by id_nouvelle DESC")){
  echo "<ul>\n";
  while ($ligne = @mysql_fetch_array($result)){    
    echo "<li>";
      if($ligne["nom_nouvelle"]!=""){echo "<p>";
      echo "<span style=\"float:left;\">".style_cherche('','nouvelle','icone')."</span>";
      echo "<b>".$ligne["nom_nouvelle"]."</b>";}
      if($ligne["info_nouvelle"]!=""){echo "<br><i>".$ligne["info_nouvelle"]."</i>";}
      if($ligne["horloge_nouvelle"]!=""){echo "&nbsp;<i>".$ligne["horloge_nouvelle"]."</i>";}
    echo "</li>\n";
  }
  echo "</ul>\n";
}
?>