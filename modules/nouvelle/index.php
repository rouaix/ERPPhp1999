<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
      
echo "<div class=\"module\" id=\"titre\">Actualit&eacute; du site</div>";
    
$sql ="select * from nouvelle order by id_nouvelle asc";
  if($result = mysql_query($sql)){
    while ($ligne = mysql_fetch_array($result)) {
      echo "<div class=\"module\" id=\"ligne\">";
      
      echo ico_supprimer($ligne,"nouvelle");

      echo ico_termine($ligne,"nouvelle");

      echo ico_modifier("nouvelle",$ligne["id_nouvelle"]);
      
      if($ligne["etat_nouvelle"]=="t"){echo "<s>";}
      echo "<b>".$ligne["nom_nouvelle"]."</b> (".$ligne["info_nouvelle"].") <i style=\"float:right;\">".$ligne["horloge_nouvelle"]."</i>";
      if($ligne["etat_nouvelle"]=="t"){echo "</s>";}
      echo "</div>\n";
    }
  }


?>