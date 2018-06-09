<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

  $result = mysql_query("select * from comptable where lien_comptable = '' or lien_comptable = '0' order by numero_comptable asc");
  while ($ligne = mysql_fetch_array($result)){
    echo "<div class=\"module\" id\"titre\">";
    echo ico_modifier("comptable",$ligne["id_comptable"]);
    echo $ligne["numero_comptable"]." - ".ucfirst($ligne["nom_comptable"])." - "."<i>".$ligne["info_comptable"]."</i>";
    echo "<br>";
    s_enfant($ligne["numero_comptable"],"comptable",$ligne["numero_comptable"]);
    echo "</div>\n";
   }

function s_enfant($x,$t,$controle){
  $sql = "select * from ".$t." where lien_".$t."='".$x."' and numero_".$t."!= ".$controle." order by numero_comptable asc";
  $result = mysql_query($sql);
  while ($ligne = mysql_fetch_array($result)){
      echo "<div class=\"module\" id\"ligne\" style=\"margin-left:20px;\">";
      echo ico_modifier("comptable",$ligne["id_comptable"]);
      echo $ligne["numero_".$t]." - ".ucfirst($ligne["nom_".$t])." - "."<i>".$ligne["info_".$t]."</i>";
      echo "<br>";
      s_enfant($ligne["numero_".$t],$t,$ligne["numero_comptable"]);
      echo "</div>\n"; 
  }
}


?>