<?php
if(file_exists("../securite.php")){include("../securite.php");}

$droits_table = table_droits($_SESSION["page"]);

if(is_array($droits_table) && isset($droits_table["613"])){
  module_titre($_SESSION["page"],'');  
  affiche_taches("where etat_".$_SESSION["page"]." =''","order by id_".$_SESSION["page"]." asc");  
  affiche_taches("where etat_".$_SESSION["page"]." !=''","order by id_".$_SESSION["page"]." asc");    
}

function affiche_taches($condition,$ordre){
  $droits_champs = champs_droits($_SESSION["page"]);  
  $r = mysql_query("SHOW FULL COLUMNS FROM ".$_SESSION["page"]);
  while($l = mysql_fetch_assoc($r)){$champs[$l["Field"]] = $l['Comment'];}
  unset($r);
  unset($l);
  
  $sql = "select * from ".$_SESSION["page"]." ".$condition." ".$ordre;
  if($result = mysql_query($sql)){
    $nb = mysql_num_rows($result);
    if($nb > 0){
      echo "<div class=\"module\" ".style_cherche('',$_SESSION["page"],'couleur').">";
      $sql = "select * from ".$_SESSION["page"]." ".$condition." ".$ordre;
      $result = mysql_query($sql);
      while ($ligne = mysql_fetch_array($result)){            
        echo "<div class=\"module\">";
        echo ico_effacer($ligne["id_".$_SESSION["page"]],$_SESSION["page"]);
        echo ico_termine($ligne,$_SESSION["page"]);        
        echo ico_archive($ligne,$_SESSION["page"]);
        echo ico_modifier($_SESSION["page"],$ligne["id_".$_SESSION["page"]]);
        while (list($key,$val) = each($ligne)){
          if($val !=""){
            if(is_array($droits_champs) && isset($droits_champs[$key]["612"])){
              echo "<div class=\"module\" id=\"champs\" title=\"".$champs[$key]." (".$key.")"."\">".$val."</div>";
            }
          }
        }
        echo "</div>\n";
      }
      echo "</div>\n";
    } 
  } 
}  
?>