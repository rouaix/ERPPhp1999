<?php

echo "<table style=\"width:100%;border-collapse:separate;border-spacing:1px;clear:both;\">\n";

if(isset($liste)&& is_array($liste)){
  reset($liste);
  while (list($key, $ligne) = each($liste)){
    if(date("Ymd",strtotime($ligne["debut_agenda"])) < date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin_agenda"])) == date("Ymd",$xjour)){
      echo "<tr>\n";
      echo "<td></td>\n";
      echo "<td class=\"module\" id=\"heure_block\">".affiche_evenement($ligne)."</td>\n";
      echo "</tr>\n";     
    }
    if(date("Ymd",strtotime($ligne["debut_agenda"])) == date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin_agenda"])) >= date("Ymd",$xjour)){      
      echo "<tr>\n";
      echo "<td id=\"heure\">".date("H",strtotime($ligne["debut_agenda"])).":".date("i",strtotime($ligne["debut_agenda"]))."</td>\n";
      echo "<td class=\"module\" id=\"heure_block\">";      
      echo affiche_evenement($ligne);
      echo "</td>\n";
      echo "</tr>\n"; 
    }
    if(date("Ymd",strtotime($ligne["debut_agenda"])) < date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin_agenda"])) > date("Ymd",$xjour)){
      echo "<tr>\n";
      echo "<td></td>\n";
      echo "<td class=\"module\" id=\"heure_block\">".affiche_evenement($ligne)."</td>\n";
      echo "</tr>\n";     
    }    
  }
}

echo "</table>\n";

function affiche_evenement($val){
  $temp = "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=agenda&acte=formulaire&formulaire=modifier&modifier=".$val["id_agenda"]."','surpopup');loadobjs();\">";
  $temp .= "<p id=\"gauche\"><b>".ucfirst($val["nom_agenda"])."</b>";
  if($val["info_agenda"] != ""){$temp .= "<p class=\"module\">".ucfirst(nl2br($val["info_agenda"]));}
  $temp .= "<p class=\"module\" id=\"droite\"><i class=\"module\">".str_pad(date("H",strtotime($val["debut_agenda"])), 2, "0", STR_PAD_LEFT).":".str_pad(date("i",strtotime($val["debut_agenda"])), 2, "0", STR_PAD_LEFT)." - ".str_pad(date("H",strtotime($val["fin_agenda"])), 2, "0", STR_PAD_LEFT).":".str_pad(date("i",strtotime($val["fin_agenda"])), 2, "0", STR_PAD_LEFT)."</i></p>";
  $temp .= "</a>\n";
  return $temp;
}

?>
