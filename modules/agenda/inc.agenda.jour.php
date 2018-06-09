<?php

if(@$_SESSION["tout"] != "o"){
  verif_debut_fin_journee_travail($xjour);
}else{
  $_SESSION["debut_agenda"] = 0;
  $_SESSION["fin_agenda"] = 23;
}

echo "<table style=\"width:100%;border-collapse:separate;border-spacing:1px;clear:both;\">\n";

if(isset($liste)&& is_array($liste)){
  reset($liste);
  while (list($key, $ligne) = each($liste)){
    if(date("Ymd",strtotime($ligne["debut_agenda"])) < date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin_agenda"])) > date("Ymd",$xjour)){
      echo "<tr>\n";
      echo "<td></td>\n";
      echo "<td class=\"module\" id=\"heure_block\">".affiche_evenement_special($ligne)."</td>\n";
      echo "</tr>\n";     
    }
    if(date("Ymd",strtotime($ligne["debut_agenda"])) == date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin_agenda"])) >= date("Ymd",$xjour)){
      if(date("H",strtotime($ligne["debut_agenda"])) < $_SESSION["debut_agenda"]){
        echo "<tr>\n";
        echo "<td id=\"heure\">".date("H",strtotime($ligne["debut_agenda"])).":".date("i",strtotime($ligne["debut_agenda"]))."</td>\n";
        echo "<td class=\"module\" id=\"heure_block\" ";
        if(verif_heure_travail(date("H",strtotime($ligne["debut_agenda"])),0,$xjour)){echo style_cherche("","travail","couleur");}  
        echo ">";
        $m = 0;
        do {          
          if(verif_evenement($ligne,$xjour,date("H",strtotime($ligne["debut_agenda"])),$m)){
            $temp = affiche_evenement_debut($ligne);
          }else{
            $temp = affiche_evenement($liste,date("H",strtotime($ligne["debut_agenda"])),$xjour,$m);
          }
          if($temp != ""){echo $temp;}
          $m += 15;
        } while ($m <= 45);
        echo "</td>\n";
        echo "</tr>\n";
      }
    }
  }
}


for($h = @$_SESSION["debut_agenda"];$h <= @$_SESSION["fin_agenda"];$h ++) {
  echo "<tr>\n";
  $heure = str_pad($h, 2, "0", STR_PAD_LEFT);

  echo "<td id=\"heure\" ";
  if(verif_heure_travail($h,0,$xjour)){echo style_cherche("","travail","couleur");}
  echo ">".$heure.":00"."</td>\n";

  echo "<td class=\"module\" id=\"heure_block\" ";
  if(verif_heure_travail($h,0,$xjour)){echo style_cherche("","travail","couleur");}  
  echo ">";
  $m = 0;
  do {
    $temp = affiche_evenement($liste,$h,$xjour,$m);
    if($temp != ""){echo $temp;}else{echo "";}
    $m += 15;
  } while ($m <= 45);
  echo "</td>\n";
  echo "</tr>\n";
}

echo "<tr>\n";
echo "<td></td>\n";
echo "<td>";
if(isset($liste)&& is_array($liste)){
  reset($liste);
  while (list($key, $ligne) = each($liste)){
    if(date("Ymd",strtotime($ligne["debut_agenda"])) < date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin_agenda"])) > date("Ymd",$xjour)){
      echo affiche_evenement_special($ligne);
    }
  }
}
unset($liste);
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";


function verif_evenement($val,$xjour,$h,$m){
  $ok = false;
  $xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour), date("Y",$xjour));
  if(date("Ymd",strtotime($val["debut_agenda"])) == date("Ymd",$xjour)){
    if(date("H",strtotime($val["debut_agenda"])) == $h){
      if(date("i",strtotime($val["debut_agenda"])) >= ($m -1 ) && date("i",strtotime($val["debut_agenda"])) < ($m + 14)){
        $ok = true;
      }
    }
  }
  return $ok;
}

function affiche_evenement($liste,$heure,$xjour,$m){
  $temp = "";
  if(isset($liste)&& is_array($liste)){
    reset($liste);
    while (list($key, $val) = each($liste)){
      if(verif_evenement($val,$xjour,$heure,$m)){
        $temp = affiche_evenement_debut($val);
      }
    }
  }
  return $temp;
}

function affiche_evenement_debut($val){
  $temp = "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=agenda&acte=formulaire&formulaire=modifier&modifier=".$val["id_agenda"]."','surpopup');loadobjs();\">";
  //$temp .= "<div class=\"module\" id=\"block\" ";
  //.categorie($val,"t").
  //$temp .= style_cherche("","travail","couleur");
  //$temp .= ">";
  $temp .= "<p id=\"gauche\"><b>".ucfirst($val["nom_agenda"])."</b>";
  if($val["info_agenda"] != ""){$temp .= "<p class=\"module\">".ucfirst(nl2br($val["info_agenda"]));}
  //$temp .= "</div>";
  $temp .= "<p class=\"module\" id=\"droite\"><i class=\"module\">".str_pad(date("H",strtotime($val["debut_agenda"])), 2, "0", STR_PAD_LEFT).":".str_pad(date("i",strtotime($val["debut_agenda"])), 2, "0", STR_PAD_LEFT)." - ".str_pad(date("H",strtotime($val["fin_agenda"])), 2, "0", STR_PAD_LEFT).":".str_pad(date("i",strtotime($val["fin_agenda"])), 2, "0", STR_PAD_LEFT)."</i></p>";
  $temp .= "</a>\n";
  return $temp;
}

function affiche_evenement_special($val){
  $temp = "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=agenda&acte=formulaire&formulaire=modifier&modifier=".$val["id_agenda"]."','surpopup');loadobjs();\">";
  //$temp .= "<div class=\"module\" id=\"block\" ";
  // categorie($val,"b")
  //$temp .= style_cherche("","travail","couleur");
  //$temp .= ">";
  $temp .= "<p id=\"gauche\"><b>".ucfirst($val["nom_agenda"])."</b>";
  $temp .= "<p class=\"module\" id=\"droite\"><i class=\"module\">Depuis le ".date("d/m/Y",strtotime($val["debut_agenda"]))." - Jusqu'au ".date("d/m/Y",strtotime($val["fin_agenda"]))."</i></p>";
  if($val["info_agenda"] != ""){$temp .= "<p class=\"module\">".ucfirst(nl2br($val["info_agenda"]));}
  $temp .= "</div>\n";
  $temp .= "</a>\n";
  return $temp;
}

unset($_SESSION["debut_agenda"]);
unset($_SESSION["fin_agenda"]);
?>
