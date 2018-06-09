<?php
//if(file_exists("../securite.php")){include("../securite.php");}

$droits_table = table_droits($_SESSION["page"]);
$droits_champs = champs_droits($_SESSION["page"]);

if(is_array($droits_table) && isset($droits_table["146"])){
module_titre($_SESSION["page"],'');

$sql = "select * from ".$_SESSION["page"]." order by nom_".$_SESSION["page"]." asc";
if($result = mysql_query($sql)){
  $nb = mysql_num_rows($result);
  //echo "<div class=\"module\" id=\"titre\">".$nb." Enregistrement".pluriel($nb)."</div>\n";
  //echo "<div id=\"form".$_SESSION["page"]."\" style=\"display:none;\"><img src=\"images/loader/chargement2.gif\"></div>";         
  if($nb > 0){
   
  echo "<div class=\"module\" ".style_cherche('','titre','couleur').">";
    //if($result = mysql_query("select * from ".$_SESSION["page"]." ")){
      //echo nombre_longueur(mysql_num_rows($result),4)." Enregistrement".pluriel(nombre_longueur(mysql_num_rows($result),4));
    //}
    echo nombre_longueur($nb,4)." Enregistrement".pluriel(nombre_longueur($nb,4));
  echo "</div>";
   
  //echo "<div class=\"table\" id=\"bloc\">";
   
  echo "<table class=\"table\" ".style_cherche('','table','couleur').">";
  echo "<tr>";
  echo "<th>";
  echo "Menu";     
  echo "</th>";  
    $r = mysql_query("SHOW FULL COLUMNS FROM ".$_SESSION["page"]);
    while($l = mysql_fetch_assoc($r)){$champs[$l["Field"]] = $l['Comment'];}
    reset($champs);
    
    while (list($key, $val) = @each($champs)){
      if(is_array($droits_champs) && isset($droits_champs[$key]["139"])){
        echo "<th onclick=\"voir('data');\">";
        if($val != ""){echo $val."<p><i>".$key."</i>";}else{echo $key."<p><i>&nbsp;</i>";}
        echo "</th>";  
      }
    }  
  echo "</tr>\n";
  
  //$sql = "select * from ".$_SESSION["page"]." order by nom_".$_SESSION["page"]." asc";
  //$result = mysql_query($sql);           
  while ($ligne = mysql_fetch_array($result)){            
    echo "<tr>";
    echo "<td id=\"ico\">";
      echo ico_supprimer($ligne,$_SESSION["page"]);
      //echo ico_effacer($ligne["id_".$_SESSION["page"]],$_SESSION["page"]);
      //echo ico_voir("div".$ligne["id"],0,0,0);      
      //echo "<a title=\"Modifier\" href=\"javascript:voir('form".$_SESSION["page"]."');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".$_SESSION["page"]."&popup=form".$_SESSION["page"]."&acte=formulaire&formulaire=modifier&modifier=".$ligne["id_".$_SESSION["page"]]."','form".$_SESSION["page"]."');loadobjs();\"><img src=\"".$_SESSION["ico"]["modifier"]."\" class=\"module\"></a>";
      //echo ico_archiver($ligne,$_SESSION["page"]);
      
      echo ico_termine($ligne,$_SESSION["page"]);
      echo ico_modifier($_SESSION["page"],$ligne["id_".$_SESSION["page"]]);                
    echo "</td>";
    while (list($key,$val) = each($ligne)){
      if(is_string($key)){
        if(is_array($droits_champs) && isset($droits_champs[$key]["139"])){
          echo "<td id=\"data\" title=\"";
          if($champs[$key] != ""){echo ucfirst($champs[$key])." (".ucfirst($key).")";}else{echo ucfirst($key);}
          echo "\">";
          if(isset($ligne["etat_".$_SESSION["page"]]) && $ligne["etat_".$_SESSION["page"]]=="t"){echo "<s>";}
          echo nl2br($val);
          if(isset($ligne["etat_".$_SESSION["page"]]) && $ligne["etat_".$_SESSION["page"]]=="t"){echo "</s>";}
          echo "</td>";
        }
      } 
    }
    echo "</tr>\n";
  }
  echo "</table>\n";
  //echo "</div>\n";
} 
}   
}   

?>